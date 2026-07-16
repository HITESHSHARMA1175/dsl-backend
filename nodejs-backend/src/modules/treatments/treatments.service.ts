import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

interface NavItem {
  name: string;
  slug: string;
  path: string;
}

interface NavColumn {
  title: string;
  subItems: NavItem[];
}

interface NavGroup {
  name: string;
  isMultiColumn: boolean;
  subItems?: NavItem[];
  columns?: NavColumn[];
}

export class TreatmentsService {
  constructor(private prisma: PrismaClient) {}

  private toNavItem(page: { treatment_name: string | null; slug: string }): NavItem {
    return { name: page.treatment_name ?? page.slug, slug: page.slug, path: `/treatments/${page.slug}` };
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
        select: { treatment_name: true, slug: true },
        orderBy: { id: 'asc' },
      });

      if (children.length === 0) {
        groups.push({
          name: category.category_name,
          isMultiColumn: false,
          subItems: ownItems.map((i) => this.toNavItem(i)),
        });
        continue;
      }

      const columns: NavColumn[] = [];
      if (ownItems.length > 0) {
        columns.push({ title: category.category_name, subItems: ownItems.map((i) => this.toNavItem(i)) });
      }

      for (const child of children) {
        const childId = Number(child.id);
        const items = await this.prisma.treatmentPage.findMany({
          where: { sub_category_id: childId, status: { not: 2 } },
          select: { treatment_name: true, slug: true },
          orderBy: { id: 'asc' },
        });
        columns.push({ title: child.category_name, subItems: items.map((i) => this.toNavItem(i)) });
      }

      // "DSL Clinic Team" is real staff (teams table), not treatment content -
      // stitched in as an extra column rather than modeled as a fake category.
      if (category.category_name === 'Medical & Injectables') {
        const team = await (this.prisma as any).teams.findMany({
          where: { status: 1, team_slug: { not: null }, team_name: { not: null } },
        });
        columns.push({
          title: 'DSL Clinic Team',
          subItems: team.map((member: any) => ({
            name: member.team_name,
            slug: member.team_slug,
            path: `/team/${member.team_slug}`,
          })),
        });
      }

      groups.push({ name: category.category_name, isMultiColumn: true, columns: columns.filter((c) => c.subItems.length > 0) });
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
      slug: page.slug,
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
}
