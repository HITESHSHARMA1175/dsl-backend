import { PrismaClient } from '@prisma/client';

export class InventoryCategoryService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).inventory_categories.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: { name: string; parent_id?: number; status?: number }) {
    return (this.prisma as any).inventory_categories.create({
      data: { category_name: data.name, parent_id: data.parent_id, status: data.status },
    });
  }

  async update(id: number, data: { name?: string; parent_id?: number; status?: number }) {
    return (this.prisma as any).inventory_categories.update({
      where: { id },
      data: { category_name: data.name, parent_id: data.parent_id, status: data.status },
    });
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
