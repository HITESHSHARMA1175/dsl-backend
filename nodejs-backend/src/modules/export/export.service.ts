import { PrismaClient } from '@prisma/client';

export class ExportService {
  constructor(private prisma: PrismaClient) {}

  async exportLeads(filters: any = {}) {
    const where: any = {};
    if (filters.status) where.status = filters.status;
    if (filters.source) where.source = filters.source;

    const leads = await (this.prisma as any).leads.findMany({
      where,
      orderBy: { id: 'desc' },
    });
    return leads;
  }

  async exportData(filters: any = {}) {
    const where: any = {};
    if (filters.status) where.status = filters.status;

    const data = await (this.prisma as any).leads.findMany({
      where: { ...where, is_lead: 'No' },
      orderBy: { id: 'desc' },
    });
    return data;
  }
}
