import { PrismaClient } from '@prisma/client';

export class TenantService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).tenants.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: { name: string; email?: string; phone?: string; address?: string }) {
    const [first_name, ...rest] = data.name.split(' ');
    return (this.prisma as any).tenants.create({
      data: {
        first_name,
        last_name: rest.join(' ') || undefined,
        email: data.email,
        mobile_no: data.phone,
        address: data.address,
      },
    });
  }

  async update(id: number, data: { name?: string; email?: string; phone?: string; address?: string }) {
    let first_name: string | undefined;
    let last_name: string | undefined;
    if (data.name !== undefined) {
      const parts = data.name.split(' ');
      first_name = parts[0];
      last_name = parts.slice(1).join(' ') || undefined;
    }
    return (this.prisma as any).tenants.update({
      where: { id },
      data: {
        first_name,
        last_name,
        email: data.email,
        mobile_no: data.phone,
        address: data.address,
      },
    });
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
