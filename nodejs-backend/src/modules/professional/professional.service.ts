import { PrismaClient } from '@prisma/client';

export class ProfessionalService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return this.prisma.professional.findMany({
      select: {
        id: true,
        professional_name: true,
        designation: true,
        profession: true,
        profile: true,
      },
    });
  }

  async create(data: {
    professional_name: string;
    designation?: string;
    profession?: string;
    work_category?: string;
    profile?: string;
  }) {
    return this.prisma.professional.create({ data });
  }

  async update(id: number, data: {
    professional_name?: string;
    designation?: string;
    profession?: string;
    work_category?: string;
    profile?: string;
  }) {
    return this.prisma.professional.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await this.prisma.professional.delete({ where: { id } });
    return { message: 'Professional deleted successfully' };
  }

  async toggleStatus(id: number) {
    const professional = await this.prisma.professional.findUniqueOrThrow({ where: { id } });
    const newStatus = professional.status === 1 ? 0 : 1;
    return this.prisma.professional.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
