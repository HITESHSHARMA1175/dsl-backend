import { PrismaClient } from '@prisma/client';

export class CategoryService {
  constructor(private prisma: PrismaClient) {}

  async list(parentId: number = 0) {
    return this.prisma.propertyCategory.findMany({
      where: { parent_id: parentId },
      select: { id: true, parent_id: true, category_name: true },
    });
  }

  async create(data: { category_name: string; parent_id?: number }) {
    return this.prisma.propertyCategory.create({
      data: {
        category_name: data.category_name,
        parent_id: data.parent_id ?? 0,
      },
    });
  }

  async update(id: number, data: { category_name?: string; parent_id?: number }) {
    return this.prisma.propertyCategory.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await this.prisma.propertyCategory.delete({ where: { id } });
    return { message: 'Category deleted successfully' };
  }
}
