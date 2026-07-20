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
  description: true,
  description1: true,
  icon: true,
  image1: true,
  image2: true,
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

const ICON_BASE_URL = 'https://cdn.diamondskinlondon.com/icons/';

export class SkinConditionService {
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
      icon: condition.icon ? `${ICON_BASE_URL}${condition.icon}` : null,
      meta_title: condition.meta_title,
      meta_description: condition.meta_description,
      hero_badge: condition.hero_badge,
      short_description: condition.description,
      long_description: condition.description1,
      // Unresolved - see method doc comment above. Raw filenames are on
      // condition.image1 / condition.image2 in the DB if needed for debugging.
      hero_image: null,
      card_image: null,
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
