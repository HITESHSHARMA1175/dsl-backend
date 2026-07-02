import { prisma } from '../../config/database';

export class MedicalHistoryService {
  async list() {
    return (prisma as any).medical_history.findMany();
  }

  async create(data: any) {
    return (prisma as any).medical_history.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).medical_history.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).medical_history.delete({ where: { id } });
    return { message: 'Medical history deleted successfully' };
  }
}
