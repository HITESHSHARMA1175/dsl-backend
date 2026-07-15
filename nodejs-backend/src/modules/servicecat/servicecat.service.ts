import { AppError } from '../../shared/utils/appError';

/**
 * Service Category hierarchy management.
 * Maps to the `property_category_mains` table which supports a multi-level
 * hierarchy via the `parent_id` column (NULL = top-level main category).
 */
export class ServicecatService {
  constructor(private prisma: any) {}

  private slugify(name: string) {
    return name
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)/g, '');
  }

  private async assertSlugAvailable(slug: string, excludeId?: number) {
    if (!slug) return;
    const existing = await this.prisma.property_category_mains.findFirst({ where: { category_slug: slug } });
    if (existing && Number(existing.id) !== excludeId) {
      throw new AppError(409, 'A category with this slug already exists');
    }
  }

  private async buildBreadcrumbs(record: any): Promise<any[]> {
    const trail: any[] = [];
    let current = record;
    while (current) {
      trail.unshift({ id: Number(current.id), category_name: current.category_name, category_slug: current.category_slug });
      if (current.parent_id === null || current.parent_id === undefined) break;
      current = await this.prisma.property_category_mains.findUnique({ where: { id: current.parent_id } });
    }
    return trail;
  }

  async list(parentId?: number) {
    // Top-level categories have parent_id = NULL (not 0) in this table, so
    // "no parent_id given" must mean "top-level", not "everything flat".
    const where: any = { parent_id: parentId !== undefined ? parentId : null };
    return this.prisma.property_category_mains.findMany({
      where,
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });
  }

  async getTree() {
    const topLevel = await this.prisma.property_category_mains.findMany({
      where: { parent_id: null },
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });
    return Promise.all(
      topLevel.map(async (parent: any) => ({
        ...parent,
        children: await this.prisma.property_category_mains.findMany({
          where: { parent_id: parent.id },
          orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
        }),
      }))
    );
  }

  /**
   * Full navbar mega-menu in one call: every top-level category with its
   * treatment items nested inline (name + slug to link to). Includes draft
   * treatment pages too — the menu entry existing is separate from whether
   * that page's full content has been written yet.
   */
  async getMenu() {
    const topLevel = await this.prisma.property_category_mains.findMany({
      where: { parent_id: null, status: 1 },
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });
    return Promise.all(
      topLevel.map(async (category: any) => {
        const items = await this.prisma.treatmentPage.findMany({
          where: { category_id: Number(category.id), status: { not: 2 } },
          select: { id: true, treatment_name: true, slug: true, status: true },
          orderBy: { id: 'asc' },
        });
        return {
          id: Number(category.id),
          category_name: category.category_name,
          category_slug: category.category_slug,
          items,
        };
      })
    );
  }

  async getById(id: number) {
    const record = await this.prisma.property_category_mains.findUnique({ where: { id } });
    if (!record) {
      throw new AppError(404, 'Service category not found');
    }
    const breadcrumbs = await this.buildBreadcrumbs(record);
    return { ...record, breadcrumbs };
  }

  /** Resolves a category by slug first, falling back to numeric id. */
  async getBySlugOrId(value: string) {
    let record = await this.prisma.property_category_mains.findFirst({ where: { category_slug: value } });
    if (!record) {
      const asId = Number(value);
      if (Number.isInteger(asId) && asId > 0) {
        record = await this.prisma.property_category_mains.findUnique({ where: { id: asId } });
      }
    }
    if (!record) {
      throw new AppError(404, 'Service category not found');
    }
    const breadcrumbs = await this.buildBreadcrumbs(record);
    return { ...record, breadcrumbs };
  }

  async create(data: any) {
    const slug = data.category_slug || this.slugify(data.category_name);
    await this.assertSlugAvailable(slug);
    const payload: any = {
      parent_id: data.parent_id ?? null,
      category_name: data.category_name,
      category_slug: slug,
      description: data.description,
      meta_title: data.meta_title,
      meta_keywords: data.meta_keywords,
      meta_description: data.meta_description,
      icon: data.icon,
      banner: data.banner,
    };
    return this.prisma.property_category_mains.create({ data: payload });
  }

  async update(id: number, data: any) {
    const existing = await this.prisma.property_category_mains.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Service category not found');
    }
    const payload: any = { ...data };
    if (data.category_name && !data.category_slug) {
      payload.category_slug = this.slugify(data.category_name);
    }
    if (payload.category_slug) {
      await this.assertSlugAvailable(payload.category_slug, id);
    }
    return this.prisma.property_category_mains.update({ where: { id }, data: payload });
  }

  async delete(id: number) {
    const existing = await this.prisma.property_category_mains.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Service category not found');
    }
    await this.prisma.property_category_mains.delete({ where: { id } });
    return { message: 'Service category deleted successfully' };
  }

  async toggleStatus(id: number) {
    const record = await this.prisma.property_category_mains.findUnique({ where: { id } });
    if (!record) {
      throw new AppError(404, 'Service category not found');
    }
    const newStatus = record.status === 1 ? 0 : 1;
    return this.prisma.property_category_mains.update({
      where: { id },
      data: { status: newStatus },
    });
  }

  async updateSorting(items: { id: number; sorting_order: number }[]) {
    await Promise.all(
      items.map((item) =>
        this.prisma.property_category_mains.update({
          where: { id: item.id },
          data: { sorting_order: item.sorting_order },
        })
      )
    );
    return { message: 'Sorting order updated successfully' };
  }
}
