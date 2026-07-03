import { AppError } from '../../shared/utils/appError';

export class LeadService {
  constructor(private prisma: any) {}

  async create(data: any, addBy: number) {
    const lead = await this.prisma.leads.create({
      data: {
        name: data.name,
        mobile_no: data.mobile_no,
        email: data.email,
        source: data.source,
        message: data.message,
        assign_emp: data.assign_emp,
        campaigns: data.campaigns,
        addby: addBy,
        is_lead: 'Yes',
        is_profile_checked: '0',
        token_collect_flag: '0',
        status: 'New',
        data_status: 'New',
      },
    });

    return lead;
  }

  async list(page = 1, perPage = 10, filters?: { status?: string; assign_emp?: string; source?: string }) {
    const where: any = {};

    if (filters?.status) {
      where.status = filters.status;
    }
    if (filters?.assign_emp) {
      where.assign_emp = filters.assign_emp;
    }
    if (filters?.source) {
      where.source = filters.source;
    }

    const [items, total] = await Promise.all([
      this.prisma.leads.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { created_at: 'desc' },
      }),
      this.prisma.leads.count({ where }),
    ]);

    return { items, total };
  }

  async getById(id: number) {
    const lead = await this.prisma.leads.findUnique({
      where: { id },
    });

    if (!lead) {
      throw new AppError(404, 'Lead not found');
    }

    // Get journey entries
    const journey = await this.prisma.lead_journeys.findMany({
      where: { lead: id },
      orderBy: { id: 'desc' },
    });

    return { ...lead, journey };
  }

  async updateStatus(id: number, status: string, notes: string | undefined, updatedBy: number) {
    const existing = await this.prisma.leads.findUnique({
      where: { id },
    });

    if (!existing) {
      throw new AppError(404, 'Lead not found');
    }

    const lead = await this.prisma.leads.update({
      where: { id },
      data: { status },
    });

    // Create journey entry
    await this.prisma.lead_journeys.create({
      data: {
        lead: id,
        status,
        remark: notes,
        is_lead: 'Yes',
        assign_emp: updatedBy,
      },
    });

    return lead;
  }

  async assign(id: number, employeeId: string, assignedBy: number) {
    const existing = await this.prisma.leads.findUnique({
      where: { id },
    });

    if (!existing) {
      throw new AppError(404, 'Lead not found');
    }

    const lead = await this.prisma.leads.update({
      where: { id },
      data: {
        assign_emp: employeeId,
        assign_by: assignedBy,
        assign_date: new Date(),
      },
    });

    return lead;
  }

  async getJourney(leadId: number) {
    const journeys = await this.prisma.lead_journeys.findMany({
      where: { lead: leadId },
      orderBy: { id: 'desc' },
    });

    return journeys;
  }
}
