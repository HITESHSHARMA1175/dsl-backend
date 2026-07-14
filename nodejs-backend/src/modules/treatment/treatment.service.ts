import { PrismaClient, Prisma } from '@prisma/client';

export class TreatmentService {
  constructor(private prisma: PrismaClient) {}

  /**
   * Returns full treatment/service details (price, description, duration,
   * category) from the `properties` table - the same data backing
   * /api/v1/services - rather than the bare {id, name} lookup rows in the
   * `treatments` table. The `treatments` table itself is still used by
   * create/update/delete below, which manage a separate internal lookup.
   */
  async list(propertyCategory?: number, propertySubCategory?: number) {
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

  async create(data: { name: string; treatment_type: number }) {
    return this.prisma.treatment.create({ data });
  }

  async update(id: number, data: { name?: string; treatment_type?: number; status?: number }) {
    return this.prisma.treatment.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    return this.prisma.treatment.delete({ where: { id } });
  }
}
