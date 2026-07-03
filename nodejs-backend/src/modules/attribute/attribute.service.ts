import { PrismaClient } from '@prisma/client';

export class AttributeService {
  constructor(private prisma: PrismaClient) {}

  // Attributes CRUD
  async listAttributes() {
    return (this.prisma as any).attributes.findMany({ orderBy: { id: 'desc' } });
  }

  async createAttribute(data: { name: string; type?: string }) {
    return (this.prisma as any).attributes.create({
      data: { attribute_name: data.name, attribute_type: data.type },
    });
  }

  async updateAttribute(id: number, data: { name?: string; type?: string }) {
    return (this.prisma as any).attributes.update({
      where: { id },
      data: { attribute_name: data.name, attribute_type: data.type },
    });
  }

  async deleteAttribute(id: number) {
    await (this.prisma as any).attributes.delete({ where: { id } });
    return { message: 'Attribute deleted successfully' };
  }

  // Attribute Values CRUD
  async listValues() {
    return (this.prisma as any).attribute_values.findMany({ orderBy: { id: 'desc' } });
  }

  async createValue(data: { attribute_id: number; value: string }) {
    return (this.prisma as any).attribute_values.create({
      data: { attribute_id: data.attribute_id, attribute_value: data.value },
    });
  }

  async updateValue(id: number, data: { value?: string }) {
    return (this.prisma as any).attribute_values.update({
      where: { id },
      data: { attribute_value: data.value },
    });
  }

  async deleteValue(id: number) {
    await (this.prisma as any).attribute_values.delete({ where: { id } });
    return { message: 'Attribute value deleted successfully' };
  }

  // Map attributes to category
  async mapToCategory(categoryId: number, attributeIds: number[]) {
    // Delete existing mappings for this category
    await (this.prisma as any).property_category_attributes.deleteMany({
      where: { category_id: categoryId },
    });
    // Create new mappings
    const records = attributeIds.map((attributeId) => ({
      category_id: categoryId,
      attribute_id: attributeId,
    }));
    await (this.prisma as any).property_category_attributes.createMany({ data: records });
    return { message: 'Attributes mapped to category successfully' };
  }
}
