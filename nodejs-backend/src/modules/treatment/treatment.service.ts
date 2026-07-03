import { PrismaClient } from '@prisma/client';

export class TreatmentService {
  constructor(private prisma: PrismaClient) {}

  async list(treatmentType?: number) {
    const where = treatmentType !== undefined ? { treatment_type: treatmentType } : {};
    return this.prisma.treatment.findMany({
      where,
      select: { id: true, name: true },
    });
  }

  async create(data: { name: string; treatment_type: number }) {
    return this.prisma.treatment.create({ data });
  }

  async update(id: number, data: { name?: string; treatment_type?: number; status?: number }) {
    return this.prisma.treatment.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    return this.prisma.treatment.delete({ where: { id } });
  }
}
