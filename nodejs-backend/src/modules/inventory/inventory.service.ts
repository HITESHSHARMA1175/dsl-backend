import { prisma } from '../../config/database';

export class InventoryService {
  // Inventory items
  async list() {
    return (prisma as any).inventories.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: {
    name: string;
    category_id?: number;
    quantity?: number;
    unit?: string;
    price?: number;
    description?: string;
  }) {
    return (prisma as any).inventories.create({
      data: {
        inventory_name: data.name,
        inventory_category: data.category_id !== undefined ? String(data.category_id) : undefined,
        mrp: data.price !== undefined ? String(data.price) : undefined,
        is_available: 'Yes',
      },
    });
  }

  async update(id: number, data: {
    name?: string;
    category_id?: number;
    quantity?: number;
    unit?: string;
    price?: number;
    description?: string;
  }) {
    return (prisma as any).inventories.update({
      where: { id },
      data: {
        inventory_name: data.name,
        inventory_category: data.category_id !== undefined ? String(data.category_id) : undefined,
        mrp: data.price !== undefined ? String(data.price) : undefined,
      },
    });
  }

  async delete(id: number) {
    await (prisma as any).inventories.delete({ where: { id } });
    return { message: 'Inventory item deleted successfully' };
  }

  // Inventory categories
  async listCategories() {
    return (prisma as any).inventory_categories.findMany();
  }

  async createCategory(data: { name: string }) {
    return (prisma as any).inventory_categories.create({ data: { category_name: data.name } });
  }
}
