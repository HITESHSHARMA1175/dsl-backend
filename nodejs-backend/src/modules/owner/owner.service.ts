import { PrismaClient } from '@prisma/client';

export class OwnerService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).owners.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).owners.create({ data });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).owners.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).owners.delete({ where: { id } });
    return { message: 'Owner deleted successfully' };
  }
}
