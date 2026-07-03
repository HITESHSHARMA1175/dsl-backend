import { PrismaClient } from '@prisma/client';

export class MoveDetailService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).move_details.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: {
    property_id: number;
    tenant_id?: number;
    move_in_date?: string;
    move_out_date?: string;
    rent_amount?: number;
    deposit_amount?: number;
    notes?: string;
  }) {
    return (this.prisma as any).move_details.create({
      data: {
        property_id: data.property_id,
        tenant_id: data.tenant_id,
        movein_date: data.move_in_date,
        token_amount: data.deposit_amount !== undefined ? String(data.deposit_amount) : undefined,
        total_amount_of_new_client: data.rent_amount !== undefined ? String(data.rent_amount) : undefined,
      },
    });
  }

  async getById(id: number) {
    return (this.prisma as any).move_details.findUnique({ where: { id } });
  }

  async update(id: number, data: {
    property_id?: number;
    tenant_id?: number;
    move_in_date?: string;
    move_out_date?: string;
    rent_amount?: number;
    deposit_amount?: number;
    notes?: string;
  }) {
    return (this.prisma as any).move_details.update({
      where: { id },
      data: {
        property_id: data.property_id,
        tenant_id: data.tenant_id,
        movein_date: data.move_in_date,
        token_amount: data.deposit_amount !== undefined ? String(data.deposit_amount) : undefined,
        total_amount_of_new_client: data.rent_amount !== undefined ? String(data.rent_amount) : undefined,
      },
    });
  }

  async delete(id: number) {
    await (this.prisma as any).move_details.delete({ where: { id } });
    return { message: 'Move detail deleted successfully' };
  }
}
