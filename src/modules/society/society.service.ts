import { PrismaClient } from '@prisma/client';

export class SocietyService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).societies.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).societies.create({ data });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).societies.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).societies.delete({ where: { id } });
    return { message: 'Society deleted successfully' };
  }
}
