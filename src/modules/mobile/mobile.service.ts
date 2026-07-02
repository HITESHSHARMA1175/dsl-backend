import { PrismaClient } from '@prisma/client';

export class MobileService {
  constructor(private prisma: PrismaClient) {}

  // Brands
  async listBrands() {
    return (this.prisma as any).brands.findMany({ orderBy: { id: 'desc' } });
  }
  async createBrand(data: any) {
    return (this.prisma as any).brands.create({ data });
  }
  async updateBrand(id: number, data: any) {
    return (this.prisma as any).brands.update({ where: { id }, data });
  }
  async deleteBrand(id: number) {
    await (this.prisma as any).brands.delete({ where: { id } });
    return { message: 'Brand deleted successfully' };
  }

  // Models
  async listModels() {
    return (this.prisma as any).mmodels.findMany({ orderBy: { id: 'desc' } });
  }
  async createModel(data: any) {
    return (this.prisma as any).mmodels.create({ data });
  }
  async updateModel(id: number, data: any) {
    return (this.prisma as any).mmodels.update({ where: { id }, data });
  }
  async deleteModel(id: number) {
    await (this.prisma as any).mmodels.delete({ where: { id } });
    return { message: 'Model deleted successfully' };
  }

  // Variants
  async listVariants() {
    return (this.prisma as any).variants.findMany({ orderBy: { id: 'desc' } });
  }
  async createVariant(data: any) {
    return (this.prisma as any).variants.create({ data });
  }
  async updateVariant(id: number, data: any) {
    return (this.prisma as any).variants.update({ where: { id }, data });
  }
  async deleteVariant(id: number) {
    await (this.prisma as any).variants.delete({ where: { id } });
    return { message: 'Variant deleted successfully' };
  }

  // Colours
  async listColours() {
    return (this.prisma as any).colours.findMany({ orderBy: { id: 'desc' } });
  }
  async createColour(data: any) {
    return (this.prisma as any).colours.create({ data });
  }
  async updateColour(id: number, data: any) {
    return (this.prisma as any).colours.update({ where: { id }, data });
  }
  async deleteColour(id: number) {
    await (this.prisma as any).colours.delete({ where: { id } });
    return { message: 'Colour deleted successfully' };
  }
}
