import { prisma } from '../../config/database';

export class SellerCrmService {
  async list(page: number = 1, perPage: number = 20, filters?: any) {
    const where: any = {};
    if (filters?.status) where.status = filters.status;
    if (filters?.search) {
      where.OR = [
        { name: { contains: filters.search } },
        { email: { contains: filters.search } },
        { phone: { contains: filters.search } },
      ];
    }

    const [items, total] = await Promise.all([
      (prisma as any).seller_leads.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      (prisma as any).seller_leads.count({ where }),
    ]);

    return { items, total, page, perPage };
  }

  async create(data: any) {
    return (prisma as any).seller_leads.create({ data });
  }

  async getById(id: number) {
    return (prisma as any).seller_leads.findUnique({ where: { id } });
  }

  async updateStatus(id: number, status: string, notes?: string) {
    const updateData: any = { status };
    if (notes) updateData.notes = notes;
    return (prisma as any).seller_leads.update({
      where: { id },
      data: updateData,
    });
  }

  async getJourney(id: number) {
    return (prisma as any).seller_lead_journeys.findMany({
      where: { lead: id },
      orderBy: { id: 'desc' },
    });
  }

  // ==================== MOBILE FIELD-STAFF ENDPOINTS ====================

  /** Seller leads assigned to the logged-in field agent. */
  async assignedSellerData(userId: number, page = 1, perPage = 10) {
    const where: any = { assign_emp: userId };
    const [items, total] = await Promise.all([
      (prisma as any).seller_leads.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      (prisma as any).seller_leads.count({ where }),
    ]);
    return { items, total };
  }

  /** Details of a single seller lead plus its journey timeline. */
  async sellerDataDetails(id: number) {
    const lead = await (prisma as any).seller_leads.findUnique({ where: { id } });
    const journey = await (prisma as any).seller_lead_journeys.findMany({
      where: { lead: id },
      orderBy: { id: 'desc' },
    });
    return { ...lead, journey };
  }

  /** Field agent updates a seller lead (status + journey entry). */
  async sellerDataUpdate(userId: number, id: number, data: any) {
    const lead = await (prisma as any).seller_leads.update({
      where: { id },
      data: {
        lead_status: data.lead_status ?? undefined,
        call_status: data.call_status ?? undefined,
        meeting_status: data.meeting_status ?? undefined,
      },
    });

    await (prisma as any).seller_lead_journeys.create({
      data: {
        lead: id,
        status: data.lead_status ?? data.status,
        remark: data.remark,
        assign_emp: userId,
        addby: userId,
      },
    });

    return lead;
  }
}
