import { PrismaClient } from '@prisma/client';

export class ReportService {
  constructor(private prisma: PrismaClient) {}

  async getCustomers(filters: any = {}) {
    return (this.prisma as any).customer.findMany({
      orderBy: { id: 'desc' },
    });
  }

  async getEmiList(filters: any = {}) {
    return (this.prisma as any).customer_emis.findMany({
      orderBy: { id: 'desc' },
    });
  }

  async getActiveEmi(filters: any = {}) {
    return (this.prisma as any).customer_emis.findMany({
      where: { payment_status: 'Active' },
      orderBy: { id: 'desc' },
    });
  }

  async getPendingEmi(filters: any = {}) {
    return (this.prisma as any).customer_emis.findMany({
      where: { payment_status: 'Pending' },
      orderBy: { id: 'desc' },
    });
  }

  async getBounceEmi(filters: any = {}) {
    return (this.prisma as any).customer_emis.findMany({
      where: { payment_status: 'Bounce' },
      orderBy: { id: 'desc' },
    });
  }
}
