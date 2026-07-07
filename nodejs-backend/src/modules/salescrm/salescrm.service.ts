import { prisma } from '../../config/database';

export class SalesCrmService {
  async list(page: number = 1, perPage: number = 20, filters?: any) {
    const where: any = { is_lead: 'No' };
    if (filters?.status) where.status = filters.status;
    if (filters?.search) {
      where.OR = [
        { name: { contains: filters.search } },
        { email: { contains: filters.search } },
        { phone: { contains: filters.search } },
      ];
    }

    const [items, total] = await Promise.all([
      (prisma as any).leads.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      (prisma as any).leads.count({ where }),
    ]);

    return { items, total, page, perPage };
  }

  async create(data: any) {
    return (prisma as any).leads.create({
      data: { ...data, is_lead: 'No' },
    });
  }

  async getById(id: number) {
    return (prisma as any).leads.findUnique({ where: { id } });
  }

  async updateStatus(id: number, status: string, notes?: string) {
    const updateData: any = { status };
    if (notes) updateData.notes = notes;
    return (prisma as any).leads.update({
      where: { id },
      data: updateData,
    });
  }

  async assign(id: number, empId: number) {
    return (prisma as any).leads.update({
      where: { id },
      data: { assigned_to: empId },
    });
  }

  async getJourney(id: number) {
    return (prisma as any).lead_journeys.findMany({
      where: { lead: id },
      orderBy: { id: 'desc' },
    });
  }

  // ==================== MOBILE FIELD-STAFF ENDPOINTS ====================

  /** Field agent schedules a site visit for an assigned lead. */
  async scheduleVisit(userId: number, data: any) {
    const journey = await (prisma as any).lead_journeys.create({
      data: {
        is_lead: 'Yes',
        lead: data.lead_id,
        status: 'Schedule Visit',
        visit_date: data.visit_date,
        visit_time: data.visit_time,
        builder: data.builder_id,
        society: data.society_id,
        property: data.property_id,
        field_person: String(userId),
        remark: data.remark,
        assign_emp: userId,
        addby: userId,
      },
    });

    await (prisma as any).leads.update({
      where: { id: data.lead_id },
      data: { type: 'Schedule Visit', status: 'Schedule Visit' },
    });

    return journey;
  }

  /** Field agent records token collection for an assigned lead. */
  async tokenCollected(userId: number, data: any) {
    const journey = await (prisma as any).lead_journeys.create({
      data: {
        is_lead: 'Yes',
        lead: data.lead_id,
        status: 'Token Collect',
        token_amount: data.token_amount ?? 0,
        builder: data.builder_id,
        society: data.society_id,
        property: data.property_id,
        field_person: String(userId),
        remark: data.remark,
        assign_emp: userId,
        addby: userId,
      },
    });

    await (prisma as any).lead_payments.create({
      data: {
        lead: data.lead_id,
        lead_journey: journey.id,
        user_id: userId,
        builder_id: data.builder_id,
        society_id: data.society_id,
        property_id: data.property_id,
        amount: data.token_amount ?? 0,
        remark: data.remark,
        addby: userId,
        status: 'Pending',
      },
    });

    await (prisma as any).leads.update({
      where: { id: data.lead_id },
      data: { type: 'Token Collect', status: 'Token Collect', token_collect_flag: 'Yes' },
    });

    return journey;
  }

  /** Leads assigned to the field agent that are at the "Schedule Visit" stage. */
  async getScheduleToken(userId: number) {
    return (prisma as any).$queryRawUnsafe(
      `SELECT id, name, email, mobile_no, source, status, data_status, type, assign_emp, token_collect_flag
       FROM leads
       WHERE assign_emp = ? AND type = 'Schedule Visit'
       ORDER BY id DESC`,
      userId
    );
  }

  /** Leads assigned to the field agent that are at the "Token Collect" stage. */
  async getTokenCollected(userId: number) {
    return (prisma as any).$queryRawUnsafe(
      `SELECT id, name, email, mobile_no, source, status, data_status, type, assign_emp, token_collect_flag
       FROM leads
       WHERE assign_emp = ? AND type = 'Token Collect'
       ORDER BY id DESC`,
      userId
    );
  }

  /** Details of a single lead plus its journey timeline. */
  async getScheduleTokenDetails(id: number) {
    const leadRows: any[] = await (prisma as any).$queryRawUnsafe(
      `SELECT id, name, email, mobile_no, source, status, data_status, type, assign_emp, token_collect_flag, message, campaigns
       FROM leads WHERE id = ? LIMIT 1`,
      id
    );
    const journey = await (prisma as any).$queryRawUnsafe(
      `SELECT id, \`lead\`, status, visit_date, visit_time, token_amount, remark, assign_emp, field_person
       FROM lead_journeys WHERE \`lead\` = ? ORDER BY id DESC`,
      id
    );
    return { ...(leadRows[0] || {}), journey };
  }
}
