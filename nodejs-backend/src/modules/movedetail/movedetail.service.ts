import { PrismaClient } from '@prisma/client';

export class MoveDetailService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).move_details.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).move_details.create({ data });
  }

  async getById(id: number) {
    return (this.prisma as any).move_details.findUnique({ where: { id } });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).move_details.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).move_details.delete({ where: { id } });
    return { message: 'Move detail deleted successfully' };
  }
}
