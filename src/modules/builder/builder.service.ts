import { PrismaClient } from '@prisma/client';

export class BuilderService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).builders.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).builders.create({ data });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).builders.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).builders.delete({ where: { id } });
    return { message: 'Builder deleted successfully' };
  }
}
