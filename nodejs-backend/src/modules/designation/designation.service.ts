import { PrismaClient } from '@prisma/client';

export class DesignationService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).designations.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).designations.create({ data });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).designations.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).designations.delete({ where: { id } });
    return { message: 'Designation deleted successfully' };
  }
}
