import { prisma } from '../../config/database';

export class InventoryService {
  // Inventory items
  async list() {
    return (prisma as any).inventory.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (prisma as any).inventory.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).inventory.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).inventory.delete({ where: { id } });
    return { message: 'Inventory item deleted successfully' };
  }

  // Inventory categories
  async listCategories() {
    return (prisma as any).inventory_category.findMany();
  }

  async createCategory(data: any) {
    return (prisma as any).inventory_category.create({ data });
  }
}
