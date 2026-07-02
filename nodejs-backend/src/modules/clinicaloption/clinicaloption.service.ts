import { prisma } from '../../config/database';

export class ClinicalOptionService {
  async list() {
    return (prisma as any).clinical_option.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (prisma as any).clinical_option.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).clinical_option.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).clinical_option.delete({ where: { id } });
    return { message: 'Clinical option deleted successfully' };
  }
}
