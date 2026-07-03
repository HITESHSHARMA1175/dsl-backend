import { prisma } from '../../config/database';

export class MedicalHistoryService {
  async list() {
    return (prisma as any).medical_histories.findMany();
  }

  async create(data: any) {
    return (prisma as any).medical_histories.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).medical_histories.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).medical_histories.delete({ where: { id } });
    return { message: 'Medical history deleted successfully' };
  }
}
