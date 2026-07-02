import { PrismaClient } from '@prisma/client';

export class InventoryCategoryService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).inventory_categories.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).inventory_categories.create({ data });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).inventory_categories.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).inventory_categories.delete({ where: { id } });
    return { message: 'Inventory category deleted successfully' };
  }

  async getSubCategories(parentId: number) {
    return (this.prisma as any).inventory_categories.findMany({
      where: { parent_id: parentId },
      orderBy: { id: 'desc' },
    });
  }
}
