import { PrismaClient } from '@prisma/client';

export class ClinicService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return this.prisma.clinic.findMany();
  }

  async create(data: {
    name: string;
    address?: string;
    city?: string;
    postcode?: string;
    phone?: string;
    email?: string;
    status?: string;
  }) {
    return this.prisma.clinic.create({ data });
  }

  async update(id: number, data: {
    name?: string;
    address?: string;
    city?: string;
    postcode?: string;
    phone?: string;
    email?: string;
    status?: string;
  }) {
    return this.prisma.clinic.update({ where: { id }, data });
  }

  async delete(id: number) {
    await this.prisma.clinic.delete({ where: { id } });
    return { message: 'Clinic deleted successfully' };
  }

  async toggleStatus(id: number) {
    const record = await this.prisma.clinic.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.clinic.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
