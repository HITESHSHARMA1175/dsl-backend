import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

export class TreatmentPageService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return this.prisma.treatmentPage.findMany({
      where: { status: 1 },
      select: { id: true, slug: true, service_id: true, status: true, updated_at: true },
      orderBy: { id: 'desc' },
    });
  }

  async listAdmin() {
    return this.prisma.treatmentPage.findMany({ orderBy: { id: 'desc' } });
  }

  async getBySlug(slug: string) {
    const page = await this.prisma.treatmentPage.findUnique({ where: { slug } });
    if (!page || page.status !== 1) {
      throw new AppError(404, 'Treatment page not found');
    }
    return page;
  }

  async getById(id: number) {
    const page = await this.prisma.treatmentPage.findUnique({ where: { id } });
    if (!page) {
      throw new AppError(404, 'Treatment page not found');
    }
    return page;
  }

  async create(data: any) {
    const existing = await this.prisma.treatmentPage.findUnique({ where: { slug: data.slug } });
    if (existing) {
      throw new AppError(409, 'A treatment page with this slug already exists');
    }
    return this.prisma.treatmentPage.create({ data });
  }

  async update(id: number, data: any) {
    await this.getById(id);
    if (data.slug) {
      const existing = await this.prisma.treatmentPage.findUnique({ where: { slug: data.slug } });
      if (existing && existing.id !== id) {
        throw new AppError(409, 'A treatment page with this slug already exists');
      }
    }
    return this.prisma.treatmentPage.update({ where: { id }, data });
  }

  async delete(id: number) {
    await this.getById(id);
    await this.prisma.treatmentPage.delete({ where: { id } });
    return { message: 'Treatment page deleted successfully' };
  }
}
