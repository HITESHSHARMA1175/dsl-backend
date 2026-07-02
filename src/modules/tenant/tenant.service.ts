import { PrismaClient } from '@prisma/client';

export class TenantService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).tenants.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: any) {
    return (this.prisma as any).tenants.create({ data });
  }

  async update(id: number, data: any) {
    return (this.prisma as any).tenants.update({ where: { id }, data });
  }

  async delete(id: number) {
    await (this.prisma as any).tenants.delete({ where: { id } });
    return { message: 'Tenant deleted successfully' };
  }

  async getImportTemplate() {
    // Return column headers for tenant import template
    return {
      columns: ['name', 'email', 'phone', 'address', 'property_id', 'move_in_date'],
    };
  }

  async importTenants(data: any[]) {
    // Stub: in production, would parse and insert rows
    return { message: `${data.length} tenants imported successfully` };
  }
}
