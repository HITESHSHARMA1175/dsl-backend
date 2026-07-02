import { prisma } from '../../config/database';

export class RedUrlService {
  async list() {
    return (prisma as any).redurl.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (prisma as any).redurl.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).redurl.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).redurl.delete({ where: { id } });
    return { message: 'Redirect URL deleted successfully' };
  }
}
