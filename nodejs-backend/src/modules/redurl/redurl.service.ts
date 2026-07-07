import { prisma } from '../../config/database';

export class RedUrlService {
  async list() {
    return (prisma as any).redurls.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (prisma as any).redurls.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).redurls.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).redurls.delete({ where: { id } });
    return { message: 'Redirect URL deleted successfully' };
  }
}
