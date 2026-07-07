import { AppError } from '../../shared/utils/appError';

/**
 * Service Category hierarchy management.
 * Maps to the `property_category_mains` table which supports a multi-level
 * hierarchy via the `parent_id` column (0 = top-level main category).
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

  async list(parentId?: number) {
    const where: any = {};
    if (parentId !== undefined) {
      where.parent_id = parentId;
    }
    return this.prisma.property_category_mains.findMany({
      where,
      orderBy: [{ sorting_order: 'asc' }, { id: 'desc' }],
    });
  }

  async getById(id: number) {
    const record = await this.prisma.property_category_mains.findUnique({ where: { id } });
    if (!record) {
      throw new AppError(404, 'Service category not found');
    }
    return record;
  }

  async create(data: any) {
    const payload: any = {
      parent_id: data.parent_id ?? 0,
      category_name: data.category_name,
      category_slug: data.category_slug || this.slugify(data.category_name),
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
