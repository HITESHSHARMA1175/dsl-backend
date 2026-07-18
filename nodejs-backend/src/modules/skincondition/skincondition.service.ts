import { prisma } from '../../config/database';

const PUBLIC_SELECT = {
  id: true,
  category_name: true,
  category_slug: true,
  description: true,
  icon: true,
  parent_id: true,
  sorting_order: true,
} as const;

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
