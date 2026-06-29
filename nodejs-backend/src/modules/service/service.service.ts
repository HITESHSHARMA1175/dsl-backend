import { PrismaClient } from '@prisma/client';

export class ServiceService {
  constructor(private prisma: PrismaClient) {}

  async list(propertyCategory?: number, propertySubCategory?: number) {
    const where: Record<string, unknown> = { status: '1' };
    if (propertyCategory !== undefined) {
      where.property_category = propertyCategory;
    }
    if (propertySubCategory !== undefined) {
      where.property_sub_category = propertySubCategory;
    }
    return this.prisma.property.findMany({ where });
  }

  async create(data: {
    property_name: string;
    description?: string;
    long_description?: string;
    price?: number;
    discounted_price?: number;
    number_of_members_required?: number;
    duration?: number;
    sessions?: number;
    property_category?: number;
    property_sub_category?: number;
    parent_id?: number;
    profile?: string;
    status?: string;
  }) {
    return this.prisma.property.create({ data });
  }

  async update(id: number, data: {
    property_name?: string;
    description?: string;
    long_description?: string;
    price?: number;
    discounted_price?: number;
    number_of_members_required?: number;
    duration?: number;
    sessions?: number;
    property_category?: number;
    property_sub_category?: number;
    parent_id?: number;
    profile?: string;
    status?: string;
  }) {
    return this.prisma.property.update({ where: { id }, data });
  }

  async delete(id: number) {
    await this.prisma.property.delete({ where: { id } });
    return { message: 'Service deleted successfully' };
  }

  async toggleStatus(id: number) {
    const record = await this.prisma.property.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.property.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
