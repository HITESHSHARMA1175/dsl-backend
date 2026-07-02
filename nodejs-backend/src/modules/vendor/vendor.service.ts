import { prisma } from '../../config/database';

export class VendorService {
  async list() {
    return (prisma as any).vendor.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (prisma as any).vendor.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).vendor.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).vendor.delete({ where: { id } });
    return { message: 'Vendor deleted successfully' };
  }
}
