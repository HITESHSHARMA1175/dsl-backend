import { prisma } from '../../config/database';
import { AppError } from '../../shared/utils/appError';

const PUBLIC_SELECT = {
  id: true,
  category_name: true,
  category_slug: true,
  description: true,
  icon: true,
  parent_id: true,
  sorting_order: true,
} as const;

const DETAIL_SELECT = {
  id: true,
  category_name: true,
  category_slug: true,
  parent_id: true,
  sorting_order: true,
  meta_title: true,
  meta_description: true,
  meta_keywords: true,
  description: true,
  description1: true,
  description3: true,
  icon: true,
  icon_large: true,
  image1: true,
  image2: true,
  image3: true,
  image4: true,
  category_name_cn: true,
  description_cn: true,
  description3_cn: true,
  category_name_ar: true,
  description_ar: true,
  description3_ar: true,
  hero_badge: true,
  card_title: true,
  card_description: true,
  card_badge: true,
  card_trust_label: true,
  treatment_stats: true,
  pricing: true,
  before_after: true,
  testimonials: true,
} as const;

const resolveStoredImage = (value?: string | null) => {
  if (!value) return null;
  const trimmed = value.trim();
  if (!trimmed) return null;
  if (/^https?:\/\//i.test(trimmed) || trimmed.startsWith('/')) return trimmed;
  if (trimmed.startsWith('uploads/')) return `/${trimmed}`;
  return `/uploads/${trimmed}`;
};

interface NavItem {
  id?: number;
  name: string;
  slug?: string;
  path?: string;
}

interface NavColumn {
  id?: number;
  title: string;
  subItems: NavItem[];
}

interface NavGroup {
  id?: number;
  name: string;
  isMultiColumn: boolean;
  subItems?: NavItem[];
  columns?: NavColumn[];
}

export class SkinConditionService {
  private slugify(name: string) {
    return name
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)/g, '');
  }

  private toNavItem(condition: any): NavItem {
    const slug = condition.category_slug || this.slugify(condition.category_name || 'condition');
    return {
      id: Number(condition.id),
      name: condition.category_name || slug,
      slug,
      path: `/conditions/${slug}`,
    };
  }

  private getSlugFromItem(item: { name: string; slug?: string; path?: string }) {
    const pathSlug = item.path?.trim().split('/').filter(Boolean).pop();
    return this.slugify(item.slug || pathSlug || item.name);
  }

  private async upsertCondition(input: { id?: number; name: string; parentId: number; order: number }) {
    const slug = this.slugify(input.name);
    let existing: any = null;

    if (input.id) {
      existing = await (prisma as any).propertyCategory.findFirst({
        where: { id: input.id, is_condition: 'Yes' },
        select: PUBLIC_SELECT,
      });
    }

    if (!existing) {
      existing = await (prisma as any).propertyCategory.findFirst({
        where: { category_slug: slug, parent_id: input.parentId, is_condition: 'Yes' },
        select: PUBLIC_SELECT,
      });
    }

    const data = {
      is_condition: 'Yes',
      is_top: 'No',
      parent_id: input.parentId,
      category_name: input.name,
      category_slug: slug,
      sorting_order: input.order,
      status: 1,
    };

    if (existing) {
      await (prisma as any).propertyCategory.updateMany({
        where: { id: Number(existing.id) },
        data,
      });
      return { ...existing, ...data, id: Number(existing.id) };
    }

    return (prisma as any).propertyCategory.create({ data, select: PUBLIC_SELECT });
  }

  async getNavbar(includeEmpty = false): Promise<NavGroup[]> {
    const topLevel = await (prisma as any).propertyCategory.findMany({
      where: { is_condition: 'Yes', parent_id: 0, status: 1 },
      select: PUBLIC_SELECT,
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });

    const groups = await Promise.all(
      topLevel.map(async (condition: any) => {
        const conditionId = Number(condition.id);
        const subConditions = await (prisma as any).propertyCategory.findMany({
          where: { is_condition: 'Yes', parent_id: conditionId, status: 1 },
          select: PUBLIC_SELECT,
          orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
        });

        return {
          id: conditionId,
          name: condition.category_name || condition.category_slug || `Condition ${conditionId}`,
          slug: condition.category_slug,
          path: `/conditions/${condition.category_slug}`,
          isMultiColumn: false,
          subItems: subConditions.map((item: any) => this.toNavItem(item)),
        };
      })
    );

    if (includeEmpty) return groups;
    return groups.filter((group) => (group.subItems ?? []).length > 0);
  }

  async updateNavbar(menu: NavGroup[]) {
    const activeTopIds = new Set<number>();
    const activeSubIds = new Set<number>();
    const subSyncTopIds = new Set<number>();

    for (const [groupIndex, group] of menu.entries()) {
      const top = await this.upsertCondition({
        id: group.id && group.id > 0 ? group.id : undefined,
        name: group.name,
        parentId: 0,
        order: groupIndex + 1,
      });
      const topId = Number(top.id);
      activeTopIds.add(topId);

      const subItems = group.isMultiColumn
        ? (group.columns ?? []).flatMap((column) => column.subItems ?? [])
        : group.subItems ?? [];
      const shouldSyncSubItems = group.isMultiColumn || subItems.length > 0;

      if (shouldSyncSubItems) {
        subSyncTopIds.add(topId);
        for (const [itemIndex, item] of subItems.entries()) {
          const slug = this.getSlugFromItem(item);
          const sub = await this.upsertCondition({
            id: item.id && item.id > 0 ? item.id : undefined,
            name: item.name,
            parentId: topId,
            order: itemIndex + 1,
          });
          await (prisma as any).propertyCategory.updateMany({
            where: { id: Number(sub.id) },
            data: { category_slug: slug },
          });
          activeSubIds.add(Number(sub.id));
        }
      }
    }

    const currentTopLevel = await (prisma as any).propertyCategory.findMany({
      where: { is_condition: 'Yes', parent_id: 0, status: 1 },
      select: { id: true },
    });
    const removedTopIds = currentTopLevel.map((c: any) => Number(c.id)).filter((id: number) => !activeTopIds.has(id));
    if (removedTopIds.length > 0) {
      await (prisma as any).propertyCategory.updateMany({
        where: { id: { in: removedTopIds } },
        data: { status: 0 },
      });
      await (prisma as any).propertyCategory.updateMany({
        where: { parent_id: { in: removedTopIds }, is_condition: 'Yes' },
        data: { status: 0 },
      });
    }

    const touchedTopIds = Array.from(subSyncTopIds);
    if (touchedTopIds.length > 0) {
      const currentSubConditions = await (prisma as any).propertyCategory.findMany({
        where: { is_condition: 'Yes', parent_id: { in: touchedTopIds }, status: 1 },
        select: { id: true },
      });
      const removedSubIds = currentSubConditions.map((c: any) => Number(c.id)).filter((id: number) => !activeSubIds.has(id));
      if (removedSubIds.length > 0) {
        await (prisma as any).propertyCategory.updateMany({
          where: { id: { in: removedSubIds } },
          data: { status: 0 },
        });
      }
    }

    return this.getNavbar();
  }

  // Main conditions (is_condition = 1, parent_id = 0)
  async list() {
    return (prisma as any).propertyCategory.findMany({
      where: { is_condition: 'Yes', parent_id: 0 },
    });
  }

  /**
   * Public condition tree: top-level conditions with their sub-conditions
   * nested inline. Explicit select avoids created_at/updated_at - some rows
   * on this legacy table have invalid zero-date values Prisma can't
   * deserialize (same issue found on `properties` earlier).
   */
  async getPublicTree() {
    const topLevel = await (prisma as any).propertyCategory.findMany({
      where: { is_condition: 'Yes', parent_id: 0, status: 1 },
      select: PUBLIC_SELECT,
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });

    return Promise.all(
      topLevel.map(async (condition: any) => ({
        ...condition,
        id: Number(condition.id),
        subConditions: (
          await (prisma as any).propertyCategory.findMany({
            where: { is_condition: 'Yes', parent_id: Number(condition.id), status: 1 },
            select: PUBLIC_SELECT,
            orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
          })
        ).map((sub: any) => ({ ...sub, id: Number(sub.id) })),
      }))
    );
  }

  /**
   * Full condition detail page: SEO, hero, card, stats, pricing, before/after,
   * testimonials, real FAQs (faqs.category_id already links to this table -
   * same mechanism the Content module's FAQ admin CRUD already manages),
   * and sub-conditions.
   *
   * hero_image/card_image are null rather than a guessed URL: our stored
   * filenames (image1/image2, e.g. "30uVnLJpCvIZp9s4F.png") don't correspond
   * to the semantic-slug path pattern seen in example payloads
   * (".../conditions/acne/hero.jpg") through any real transformation, so
   * constructing one would be fabricating a URL, not resolving a real one.
   * Only `icon`'s CDN base (cdn.diamondskinlondon.com/icons/) is confirmed,
   * because that filename matched an example exactly.
   */
  async getBySlug(slug: string) {
    const condition = await (prisma as any).propertyCategory.findFirst({
      where: { category_slug: slug, is_condition: 'Yes', status: 1 },
      select: DETAIL_SELECT,
    });
    if (!condition) {
      throw new AppError(404, 'Skin condition not found');
    }

    const id = Number(condition.id);

    const [faqs, subConditions] = await Promise.all([
      // Not filtered by status: real FAQ content on this legacy table sits at
      // status 0 (never flipped to "published" by whatever admin tool wrote
      // it), and this is a single curated resource, not a bulk public list -
      // showing it beats hiding real content behind a flag nothing sets.
      (prisma as any).faq.findMany({
        where: { category_id: id },
        orderBy: { sorting_order: 'asc' },
        select: { id: true, question: true, answer: true },
      }),
      (prisma as any).propertyCategory.findMany({
        where: { is_condition: 'Yes', parent_id: id, status: 1 },
        select: { id: true, category_name: true, category_slug: true },
        orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
      }),
    ]);

    return {
      id,
      category_name: condition.category_name,
      category_slug: condition.category_slug,
      parent_id: condition.parent_id,
      sorting_order: condition.sorting_order,
      icon: resolveStoredImage(condition.icon),
      icon_large: resolveStoredImage(condition.icon_large),
      meta_title: condition.meta_title,
      meta_description: condition.meta_description,
      meta_keywords: condition.meta_keywords,
      hero_badge: condition.hero_badge,
      short_description: condition.description,
      long_description: condition.description1,
      detailed_html: condition.description3,
      category_name_cn: condition.category_name_cn,
      description_cn: condition.description_cn,
      description3_cn: condition.description3_cn,
      category_name_ar: condition.category_name_ar,
      description_ar: condition.description_ar,
      description3_ar: condition.description3_ar,
      hero_image: resolveStoredImage(condition.image1),
      card_image: resolveStoredImage(condition.image2),
      extra_image_1: resolveStoredImage(condition.image3),
      extra_image_2: resolveStoredImage(condition.image4),
      treatment_stats: condition.treatment_stats ?? null,
      card_title: condition.card_title,
      card_description: condition.card_description,
      card_badge: condition.card_badge,
      card_trust_label: condition.card_trust_label,
      // Shape ready for real content: [{id, name, sessions, original_price, price, currency, popular}]
      pricing: condition.pricing ?? [],
      // Shape ready for real content: [{id, before_image, after_image, caption}]
      before_after: condition.before_after ?? [],
      faqs,
      // Shape ready for real content: [{id, name, rating, source, date, text}]
      testimonials: condition.testimonials ?? [],
      subConditions: subConditions.map((s: any) => ({ ...s, id: Number(s.id) })),
    };
  }

  async create(data: any) {
    return (prisma as any).propertyCategory.create({
      data: { ...data, is_condition: 'Yes', is_top: 'No', parent_id: 0 },
    });
  }

  async update(id: number, data: any) {
    return (prisma as any).propertyCategory.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).propertyCategory.delete({ where: { id } });
    return { message: 'Skin condition deleted successfully' };
  }

  async toggleStatus(id: number) {
    const condition = await (prisma as any).propertyCategory.findUnique({ where: { id } });
    if (!condition) throw new Error('Skin condition not found');
    const newStatus = condition.status === 1 ? 0 : 1;
    return (prisma as any).propertyCategory.update({
      where: { id },
      data: { status: newStatus },
    });
  }

  async updateSorting(items: { id: number; sorting: number }[]) {
    // Use updateMany (returns count, not the row) to avoid selecting legacy
    // zero-date columns on property_categories that break Prisma deserialization.
    const updates = items.map((item) =>
      (prisma as any).propertyCategory.updateMany({
        where: { id: item.id },
        data: { sorting_order: item.sorting },
      })
    );
    await Promise.all(updates);
    return { message: 'Sorting updated successfully' };
  }

  // Sub-conditions
  async listSub() {
    return (prisma as any).propertyCategory.findMany({
      where: { is_condition: 'Yes', parent_id: { not: 0 } },
    });
  }

  async createSub(data: any) {
    return (prisma as any).propertyCategory.create({
      data: { ...data, is_condition: 'Yes', is_top: 'No' },
    });
  }

  async updateSub(id: number, data: any) {
    return (prisma as any).propertyCategory.update({
      where: { id },
      data,
    });
  }

  async deleteSub(id: number) {
    await (prisma as any).propertyCategory.delete({ where: { id } });
    return { message: 'Sub-condition deleted successfully' };
  }
}
