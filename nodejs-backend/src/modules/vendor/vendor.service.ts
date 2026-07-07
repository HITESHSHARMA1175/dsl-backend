import { prisma } from '../../config/database';

export class VendorService {
  async list() {
    return (prisma as any).vendors.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (prisma as any).vendors.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).vendors.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).vendors.delete({ where: { id } });
    return { message: 'Vendor deleted successfully' };
  }
}
