import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

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

export class TreatmentsService {
  constructor(private prisma: PrismaClient) {}

  private slugify(name: string) {
    return name
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)/g, '');
  }

  private toNavItem(page: { id: number; treatment_name: string | null; slug: string }): NavItem {
    return { id: page.id, name: page.treatment_name ?? page.slug, slug: page.slug, path: `/treatments/${page.slug}` };
  }

  private getSlugFromItem(item: { name: string; slug?: string; path?: string }) {
    const pathSlug = item.path?.trim().split('/').filter(Boolean).pop();
    return this.slugify(item.slug || pathSlug || item.name);
  }

  private async upsertCategory(input: { id?: number; name: string; parentId: number | null; order: number }) {
    const slug = this.slugify(input.name);
    let existing: any = null;

    if (input.id) {
      existing = await (this.prisma as any).property_category_mains.findUnique({ where: { id: input.id } });
    }

    if (!existing) {
      existing = await (this.prisma as any).property_category_mains.findFirst({
        where: { category_slug: slug, parent_id: input.parentId },
      });
    }

    const data = {
      parent_id: input.parentId,
      category_name: input.name,
      category_slug: slug,
      sorting_order: input.order,
      status: 1,
    };

    if (existing) {
      return (this.prisma as any).property_category_mains.update({
        where: { id: Number(existing.id) },
        data,
      });
    }

    return (this.prisma as any).property_category_mains.create({ data });
  }

  private async upsertNavItem(item: NavItem, categoryId: number, subCategoryId: number | null) {
    const slug = this.getSlugFromItem(item);
    let existing = item.id
      ? await this.prisma.treatmentPage.findUnique({ where: { id: item.id } })
      : null;

    if (!existing) {
      existing = await this.prisma.treatmentPage.findUnique({ where: { slug } });
    }

    const data = {
      treatment_name: item.name,
      slug,
      category_id: categoryId,
      sub_category_id: subCategoryId,
      status: 1,
    };

    if (existing) {
      return this.prisma.treatmentPage.update({ where: { id: existing.id }, data });
    }

    return this.prisma.treatmentPage.create({ data });
  }

  /**
   * Full navbar mega-menu, matching the frontend's exact contract: flat
   * categories become {isMultiColumn:false, subItems}, categories with
   * children become {isMultiColumn:true, columns} where the parent's own
   * directly-tagged items form the first column (titled after the parent
   * itself) followed by one column per child category.
   */
  async getNavbar(): Promise<NavGroup[]> {
    const topLevel = await (this.prisma as any).property_category_mains.findMany({
      where: { parent_id: null, status: 1 },
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });

    const groups: NavGroup[] = [];

    for (const category of topLevel) {
      const categoryId = Number(category.id);
      const children = await (this.prisma as any).property_category_mains.findMany({
        where: { parent_id: categoryId },
        orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
      });

      const ownItems = await this.prisma.treatmentPage.findMany({
        where: { category_id: categoryId, sub_category_id: null, status: { not: 2 } },
        select: { id: true, treatment_name: true, slug: true },
        orderBy: { id: 'asc' },
      });

      if (children.length === 0) {
        groups.push({
          id: categoryId,
          name: category.category_name,
          isMultiColumn: false,
          subItems: ownItems.map((i) => this.toNavItem(i)),
        });
        continue;
      }

      const columns: NavColumn[] = [];
      if (ownItems.length > 0) {
        columns.push({ id: categoryId, title: category.category_name, subItems: ownItems.map((i) => this.toNavItem(i)) });
      }

      for (const child of children) {
        const childId = Number(child.id);
        const items = await this.prisma.treatmentPage.findMany({
          where: { sub_category_id: childId, status: { not: 2 } },
          select: { id: true, treatment_name: true, slug: true },
          orderBy: { id: 'asc' },
        });
        columns.push({ id: childId, title: child.category_name, subItems: items.map((i) => this.toNavItem(i)) });
      }

      // "DSL Clinic Team" is real staff (teams table), not treatment content -
      // stitched in as an extra column rather than modeled as a fake category.
      if (category.category_name === 'Medical & Injectables') {
        const team = await (this.prisma as any).teams.findMany({
          where: { status: 1, team_slug: { not: null }, team_name: { not: null } },
        });
        columns.push({
          id: -categoryId,
          title: 'DSL Clinic Team',
          subItems: team.map((member: any) => ({
            id: Number(member.id),
            name: member.team_name,
            slug: member.team_slug,
            path: `/team/${member.team_slug}`,
          })),
        });
      }

      groups.push({ id: categoryId, name: category.category_name, isMultiColumn: true, columns: columns.filter((c) => c.subItems.length > 0) });
    }

    // Drop nav groups with nothing in them (legacy categories that were never
    // part of the real navbar and have no treatment pages tagged to them).
    return groups.filter((group) => {
      const count = group.isMultiColumn
        ? (group.columns ?? []).reduce((sum, col) => sum + col.subItems.length, 0)
        : (group.subItems ?? []).length;
      return count > 0;
    });
  }

  async updateNavbar(menu: NavGroup[]) {
    const activeCategoryIds = new Set<number>();
    const activePageIds = new Set<number>();
    const touchedCategoryIds = new Set<number>();

    for (const [groupIndex, group] of menu.entries()) {
      const category = await this.upsertCategory({
        id: group.id && group.id > 0 ? group.id : undefined,
        name: group.name,
        parentId: null,
        order: groupIndex + 1,
      });
      const categoryId = Number(category.id);
      activeCategoryIds.add(categoryId);
      touchedCategoryIds.add(categoryId);

      if (group.isMultiColumn) {
        for (const [columnIndex, column] of (group.columns ?? []).entries()) {
          const isRootColumn = column.id === categoryId || this.slugify(column.title) === this.slugify(group.name);
          let subCategoryId: number | null = null;

          if (!isRootColumn) {
            const child = await this.upsertCategory({
              id: column.id && column.id > 0 ? column.id : undefined,
              name: column.title,
              parentId: categoryId,
              order: columnIndex + 1,
            });
            subCategoryId = Number(child.id);
            activeCategoryIds.add(subCategoryId);
            touchedCategoryIds.add(subCategoryId);
          }

          for (const item of column.subItems ?? []) {
            const page = await this.upsertNavItem(item, categoryId, subCategoryId);
            activePageIds.add(page.id);
          }
        }
      } else {
        for (const item of group.subItems ?? []) {
          const page = await this.upsertNavItem(item, categoryId, null);
          activePageIds.add(page.id);
        }
      }
    }

    const currentTopLevel = await (this.prisma as any).property_category_mains.findMany({
      where: { parent_id: null, status: 1 },
      select: { id: true },
    });
    const currentTopLevelIds = currentTopLevel.map((c: any) => Number(c.id));
    const removedTopLevelIds = currentTopLevelIds.filter((id: number) => !activeCategoryIds.has(id));

    if (removedTopLevelIds.length > 0) {
      await (this.prisma as any).property_category_mains.updateMany({
        where: { id: { in: removedTopLevelIds } },
        data: { status: 0 },
      });
      await this.prisma.treatmentPage.updateMany({
        where: { category_id: { in: removedTopLevelIds } },
        data: { status: 2 },
      });
    }

    const childCategories = await (this.prisma as any).property_category_mains.findMany({
      where: { parent_id: { in: Array.from(touchedCategoryIds) }, status: 1 },
      select: { id: true },
    });
    const removedChildIds = childCategories.map((c: any) => Number(c.id)).filter((id: number) => !activeCategoryIds.has(id));

    if (removedChildIds.length > 0) {
      await (this.prisma as any).property_category_mains.updateMany({
        where: { id: { in: removedChildIds } },
        data: { status: 0 },
      });
      await this.prisma.treatmentPage.updateMany({
        where: { sub_category_id: { in: removedChildIds } },
        data: { status: 2 },
      });
    }

    const categoryScope = Array.from(activeCategoryIds);
    if (categoryScope.length > 0) {
      await this.prisma.treatmentPage.updateMany({
        where: {
          OR: [{ category_id: { in: categoryScope } }, { sub_category_id: { in: categoryScope } }],
          id: { notIn: Array.from(activePageIds) },
          status: { not: 2 },
        },
        data: { status: 2 },
      });
    }

    return this.getNavbar();
  }

  /**
   * One treatment's full landing-page content, reshaped from the internal
   * TreatmentPage model into the frontend's exact nested contract. Draft
   * pages are returned too (not gated on status) since the navbar links to
   * them - only a genuinely missing slug 404s.
   */
  async getBySlug(slug: string) {
    const page = await this.prisma.treatmentPage.findUnique({
      where: { slug },
      include: { faqs: { where: { status: 1 }, orderBy: { sorting_order: 'asc' } } },
    });
    if (!page) {
      throw new AppError(404, 'Treatment page not found');
    }

    const detail = (page.detail as any) ?? {};
    const resultsSection = (page.results_section as any) ?? {};

    return {
      id: page.id,
      slug: page.slug,
      name: page.treatment_name,
      category_id: page.category_id,
      sub_category_id: page.sub_category_id,
      defaultOptionId: page.default_option_id,
      hero: {
        eyebrow: page.hero_eyebrow,
        title: page.hero_title,
        accentTitle: page.hero_accent_title,
        description: page.short_description,
        image: page.hero_image,
        imageAlt: page.hero_image_alt,
        badgeText: page.hero_badge_text,
      },
      detail: {
        image: detail.image ?? null,
        imageAlt: detail.imageAlt ?? null,
        badge: detail.badge ?? null,
        title: detail.title ?? null,
        description: detail.description ?? null,
        footer: detail.footer ?? null,
      },
      stats: page.stats ?? [],
      pricing: page.pricing ?? null,
      results: {
        eyebrow: resultsSection.eyebrow ?? null,
        title: resultsSection.title ?? null,
        description: resultsSection.description ?? null,
        items: page.before_after ?? [],
      },
      faqs: page.faqs.map((f) => ({ question: f.question, answer: f.answer })),
    };
  }

/** When both a category and sub-category are given, the sub-category must actually be a child of that category. */
  private async assertValidCategoryPair(categoryId?: number | null, subCategoryId?: number | null) {
    if (!categoryId || !subCategoryId) return;
    const sub = await (this.prisma as any).property_category_mains.findUnique({ where: { id: subCategoryId } });
    if (!sub || Number(sub.parent_id) !== categoryId) {
      throw new AppError(400, 'sub_category_id must be a child of category_id');
    }
  }

  private async resolveCategoryIdFromType(type?: string | null) {
    if (!type?.trim()) return undefined;
    const slug = this.slugify(type);
    let category = await (this.prisma as any).property_category_mains.findFirst({
      where: { category_slug: slug, parent_id: null },
      orderBy: { id: 'desc' },
    });

    if (!category) {
      category = await (this.prisma as any).property_category_mains.findFirst({
        where: { category_name: type.trim(), parent_id: null },
        orderBy: { id: 'desc' },
      });
    }

    if (category) return Number(category.id);

    const created = await this.upsertCategory({
      name: type.trim(),
      parentId: null,
      order: 8888,
    });
    return Number(created.id);
  }

  private cleanFaqs(faqs: any) {
    if (!Array.isArray(faqs)) return [];
    return faqs
      .map((f: any) => ({
        question: typeof f?.question === 'string' ? f.question.trim() : '',
        answer: typeof f?.answer === 'string' ? f.answer.trim() : '',
      }))
      .filter((f) => f.question && f.answer);
  }

  /** Maps the frontend's { name, slug, category_id, sub_category_id, pageData } contract onto TreatmentPage's internal columns. */
  private buildDataFromContract(payload: { name?: string; slug?: string; category_id?: number | null; sub_category_id?: number | null; pageData?: any }) {
    const pageData = payload.pageData ?? {};
    const data: any = {};

    if (payload.name !== undefined) data.treatment_name = payload.name;
    if (payload.slug !== undefined) data.slug = payload.slug;
    if (payload.category_id !== undefined) data.category_id = payload.category_id;
    if (payload.sub_category_id !== undefined) data.sub_category_id = payload.sub_category_id;
    if (pageData.defaultOptionId !== undefined) data.default_option_id = pageData.defaultOptionId;

    if (pageData.hero) {
      const h = pageData.hero;
      if (h.eyebrow !== undefined) data.hero_eyebrow = h.eyebrow;
      if (h.title !== undefined) data.hero_title = h.title;
      if (h.accentTitle !== undefined) data.hero_accent_title = h.accentTitle;
      if (h.description !== undefined) data.short_description = h.description;
      if (h.image !== undefined) data.hero_image = h.image;
      if (h.imageAlt !== undefined) data.hero_image_alt = h.imageAlt;
      if (h.badgeText !== undefined) data.hero_badge_text = h.badgeText;
    }

    if (pageData.detail !== undefined) data.detail = pageData.detail;
    if (pageData.pricing !== undefined) data.pricing = pageData.pricing;
    if (pageData.stats !== undefined) data.stats = pageData.stats;

    if (pageData.results) {
      data.results_section = {
        eyebrow: pageData.results.eyebrow,
        title: pageData.results.title,
        description: pageData.results.description,
      };
      if (pageData.results.items !== undefined) data.before_after = pageData.results.items;
    }

    return data;
  }

  /** Create a new treatment page from the frontend's exact { name, slug, category_id, sub_category_id, pageData } contract. Created as a draft; publish separately. */
  async createFromContract(payload: { name: string; slug: string; type?: string; category_id?: number; sub_category_id?: number; pageData?: any }) {
    const existing = await this.prisma.treatmentPage.findUnique({ where: { slug: payload.slug } });
    if (existing) {
      throw new AppError(409, 'A treatment page with this slug already exists');
    }
    const categoryId = payload.category_id ?? await this.resolveCategoryIdFromType(payload.type);
    await this.assertValidCategoryPair(categoryId, payload.sub_category_id);

    const data = this.buildDataFromContract({ ...payload, category_id: categoryId });
    const page = await this.prisma.treatmentPage.create({ data: { ...data, slug: payload.slug, status: 0 } });

    const faqs = this.cleanFaqs(payload.pageData?.faqs);
    if (faqs.length > 0) {
      await this.prisma.treatmentFaq.createMany({
        data: faqs.map((f: any, index: number) => ({
          treatment_page_id: page.id,
          question: f.question,
          answer: f.answer,
          sorting_order: index,
        })),
      });
    }

    return this.getBySlug(page.slug);
  }

  /** Update an existing treatment page from the frontend's exact { name, slug, category_id, sub_category_id, pageData } contract. */
  async updateFromContract(slug: string, payload: { name?: string; slug?: string; type?: string; category_id?: number | null; sub_category_id?: number | null; pageData?: any }) {
    const existing = await this.prisma.treatmentPage.findUnique({ where: { slug } });
    if (!existing) {
      throw new AppError(404, 'Treatment page not found');
    }

    if (payload.slug !== undefined && payload.slug !== slug) {
      const duplicate = await this.prisma.treatmentPage.findUnique({ where: { slug: payload.slug } });
      if (duplicate) {
        throw new AppError(409, 'A treatment page with this slug already exists');
      }
    }

    const resolvedTypeCategoryId = payload.category_id === undefined ? await this.resolveCategoryIdFromType(payload.type) : undefined;
    const categoryId = payload.category_id !== undefined ? payload.category_id : (resolvedTypeCategoryId ?? existing.category_id);
    const subCategoryId = payload.sub_category_id !== undefined ? payload.sub_category_id : existing.sub_category_id;
    await this.assertValidCategoryPair(categoryId, subCategoryId);

    const data = this.buildDataFromContract({
      ...payload,
      ...(resolvedTypeCategoryId !== undefined && payload.category_id === undefined ? { category_id: resolvedTypeCategoryId } : {}),
    });
    await this.prisma.treatmentPage.update({ where: { id: existing.id }, data });

    if (Array.isArray(payload.pageData?.faqs)) {
      const faqs = this.cleanFaqs(payload.pageData?.faqs);
      // Full replace - this contract represents the whole page's FAQ list, not incremental edits.
      await this.prisma.treatmentFaq.deleteMany({ where: { treatment_page_id: existing.id } });
      if (faqs.length > 0) {
        await this.prisma.treatmentFaq.createMany({
          data: faqs.map((f: any, index: number) => ({
            treatment_page_id: existing.id,
            question: f.question,
            answer: f.answer,
            sorting_order: index,
          })),
        });
      }
    }

    return this.getBySlug(data.slug ?? slug);
  }
}
