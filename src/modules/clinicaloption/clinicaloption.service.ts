import { prisma } from '../../config/database';

export class ClinicalOptionService {
  async list() {
    return (prisma as any).clinical_options.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: { name: string; parent_id?: number }) {
    return (prisma as any).clinical_options.create({
      data: { name: data.name, parent_id: data.parent_id ?? 0 },
    });
  }

  async update(id: number, data: { name?: string; parent_id?: number }) {
    return (prisma as any).clinical_options.update({
      where: { id },
      data: { name: data.name, parent_id: data.parent_id },
    });
  }

  async delete(id: number) {
    await (prisma as any).clinical_options.delete({ where: { id } });
    return { message: 'Clinical option deleted successfully' };
  }
}
