import { PrismaClient } from '@prisma/client';

export class BuyerCrmService {
  constructor(private prisma: PrismaClient) {}

  async list(page: number = 1, perPage: number = 20) {
    const skip = (page - 1) * perPage;
    const [items, total] = await Promise.all([
      (this.prisma as any).leads.findMany({
        where: { is_lead: 'Yes' },
        skip,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      (this.prisma as any).leads.count({ where: { is_lead: 'Yes' } }),
    ]);
    return { items, total, page, perPage };
  }

  async create(data: any) {
    return (this.prisma as any).leads.create({
      data: { ...data, is_lead: 'Yes' },
    });
  }

  async getById(id: number) {
    return (this.prisma as any).leads.findUnique({ where: { id } });
  }

  async updateStatus(id: number, status: string, notes?: string) {
    return (this.prisma as any).leads.update({
      where: { id },
      data: { status, notes },
    });
  }

  async getJourney(id: number) {
    const lead = await (this.prisma as any).leads.findUnique({ where: { id } });
    // Return lead activity/journey - stub for now
    return { lead, journey: [] };
  }
}
