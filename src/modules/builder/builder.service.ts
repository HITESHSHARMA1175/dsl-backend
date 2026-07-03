import { PrismaClient } from '@prisma/client';

export class BuilderService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).builders.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: { name: string; contact_person?: string; email?: string; phone?: string; address?: string }) {
    return (this.prisma as any).builders.create({
      data: {
        builder_name: data.name,
        email: data.email,
        mobile_no: data.phone,
        address: data.address,
      },
    });
  }

  async update(id: number, data: { name?: string; contact_person?: string; email?: string; phone?: string; address?: string }) {
    return (this.prisma as any).builders.update({
      where: { id },
      data: {
        builder_name: data.name,
        email: data.email,
        mobile_no: data.phone,
        address: data.address,
      },
    });
  }

  async delete(id: number) {
    await (this.prisma as any).builders.delete({ where: { id } });
    return { message: 'Builder deleted successfully' };
  }
}
