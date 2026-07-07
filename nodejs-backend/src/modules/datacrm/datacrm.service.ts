import { AppError } from '../../shared/utils/appError';
import { SendGridService } from '../../shared/services/sendgrid.service';

/**
 * Data CRM management.
 * Maps to the `data` table (separate from sales `leads`). Manages the data-lead
 * pipeline: capture, assignment, status/journey tracking, conversion and dead handling.
 */
export class DataCrmService {
  private sendgrid = new SendGridService();

  constructor(private prisma: any) {}

  async list(page = 1, perPage = 10, filters?: { status?: string; assign_emp?: number; search?: string }) {
    const where: any = { is_lead: 'No' };

    if (filters?.status) {
      where.data_status = filters.status;
    }
    if (filters?.assign_emp) {
      where.assign_emp = filters.assign_emp;
    }
    if (filters?.search) {
      where.OR = [
        { name: { contains: filters.search } },
        { email: { contains: filters.search } },
        { mobile_no: { contains: filters.search } },
      ];
    }

    const [items, total] = await Promise.all([
      this.prisma.data.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.data.count({ where }),
    ]);

    return { items, total };
  }

  async getById(id: number) {
    const record = await this.prisma.data.findUnique({ where: { id } });
    if (!record) {
      throw new AppError(404, 'Data record not found');
    }
    const journey = await this.prisma.data_journeys.findMany({
      where: { lead: id },
      orderBy: { id: 'desc' },
    });
    return { ...record, journey };
  }

  async create(data: any, addBy: number) {
    return this.prisma.data.create({
      data: {
        is_lead: 'No',
        is_called: 'No',
        is_connected_call: 'No',
        token_collect_flag: 'No',
        name: data.name,
        email: data.email,
        mobile_no: data.mobile_no,
        alt_mobile_no: data.alt_mobile_no,
        city: data.city,
        source: data.source,
        message: data.message,
        campaigns: data.campaigns,
        property_id: data.property_id,
        builder_id: data.builder_id,
        society_id: data.society_id,
        assign_emp: data.assign_emp,
        status: 'New',
        data_status: 'New',
        addby: addBy,
      },
    });
  }

  async update(id: number, data: any) {
    const existing = await this.prisma.data.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Data record not found');
    }
    return this.prisma.data.update({ where: { id }, data });
  }

  async updateStatus(id: number, status: string, remark: string | undefined, updatedBy: number) {
    const existing = await this.prisma.data.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Data record not found');
    }

    const record = await this.prisma.data.update({
      where: { id },
      data: { data_status: status, status },
    });

    await this.prisma.data_journeys.create({
      data: {
        is_lead: 'No',
        lead: id,
        status,
        remark,
        assign_emp: updatedBy,
      },
    });

    // Notify the contact of their status change (best-effort)
    if (existing.email) {
      try {
        await this.sendgrid.sendDataStatusChangeMail(existing.email, {
          dataId: id,
          name: existing.name ?? '',
          oldStatus: existing.data_status ?? '',
          newStatus: status,
        });
      } catch { /* email failure shouldn't block the status update */ }
    }

    return record;
  }

  async assign(id: number, employeeId: number, assignedBy: number) {
    const existing = await this.prisma.data.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Data record not found');
    }
    return this.prisma.data.update({
      where: { id },
      data: {
        assign_emp: employeeId,
        assign_by: assignedBy,
        assign_date: new Date(),
      },
    });
  }

  async markDead(id: number, deadBy: number) {
    const existing = await this.prisma.data.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Data record not found');
    }
    return this.prisma.data.update({
      where: { id },
      data: {
        data_status: 'Dead',
        status: 'Dead',
        dead_by: deadBy,
        dead_date: new Date(),
      },
    });
  }

  async getJourney(dataId: number) {
    return this.prisma.data_journeys.findMany({
      where: { lead: dataId },
      orderBy: { id: 'desc' },
    });
  }

  async getImportLogs(page = 1, perPage = 10) {
    const [items, total] = await Promise.all([
      this.prisma.data_import_logs.findMany({
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.data_import_logs.count(),
    ]);
    return { items, total };
  }

  async getImportErrors(importId: number) {
    return this.prisma.data_errors.findMany({
      where: { import_id: importId },
      orderBy: { id: 'desc' },
    });
  }
}
