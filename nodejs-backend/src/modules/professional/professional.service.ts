import { PrismaClient } from '@prisma/client';

export class ProfessionalService {
  constructor(private prisma: PrismaClient) {}

  async list(parentId?: number) {
    const where = parentId !== undefined ? { parent_id: parentId } : {};
    return this.prisma.professional.findMany({
      where,
      select: {
        id: true,
        professional_name: true,
        designation: true,
        profession: true,
        profile: true,
        rating: true,
      },
    });
  }

  async create(data: {
    professional_name: string;
    designation?: string;
    profession?: string;
    parent_id?: number;
    category_ids?: string;
    profile?: string;
    rating?: number;
  }) {
    return this.prisma.professional.create({ data });
  }

  async update(id: number, data: {
    professional_name?: string;
    designation?: string;
    profession?: string;
    parent_id?: number;
    category_ids?: string;
    profile?: string;
    rating?: number;
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
    const newStatus = professional.status === '1' ? '0' : '1';
    return this.prisma.professional.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
