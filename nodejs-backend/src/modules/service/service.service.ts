import { PrismaClient, Prisma } from '@prisma/client';

export class ServiceService {
  constructor(private prisma: PrismaClient) {}

  async list(propertyCategory?: number, propertySubCategory?: number) {
    // property_category / property_sub_category are JSON columns with
    // inconsistent legacy data: some rows store a bare number (e.g. 22),
    // others store a JSON array of strings (e.g. ["268"]). Match both.
    const conditions: Prisma.Sql[] = [Prisma.sql`status = 1`];

    if (propertyCategory !== undefined && !Number.isNaN(propertyCategory)) {
      const idStr = String(propertyCategory);
      conditions.push(Prisma.sql`(
        JSON_UNQUOTE(JSON_EXTRACT(property_category, '$')) = ${idStr}
        OR JSON_CONTAINS(property_category, JSON_QUOTE(${idStr}))
      )`);
    }

    if (propertySubCategory !== undefined && !Number.isNaN(propertySubCategory)) {
      const idStr = String(propertySubCategory);
      conditions.push(Prisma.sql`(
        JSON_UNQUOTE(JSON_EXTRACT(property_sub_category, '$')) = ${idStr}
        OR JSON_CONTAINS(property_sub_category, JSON_QUOTE(${idStr}))
      )`);
    }

    return this.prisma.$queryRaw`
      SELECT id, property_name, description, price, discounted_price, duration,
             property_category, property_sub_category, profile, status
      FROM properties
      WHERE ${Prisma.join(conditions, ' AND ')}
      ORDER BY id DESC
    `;
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
    status?: number;
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
    status?: number;
  }) {
    return this.prisma.property.update({ where: { id }, data });
  }

  async delete(id: number) {
    await this.prisma.property.delete({ where: { id } });
    return { message: 'Service deleted successfully' };
  }

  async toggleStatus(id: number) {
    const record = await (this.prisma as any).property.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === 1 ? 0 : 1;
    return (this.prisma as any).property.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
