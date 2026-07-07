import { PrismaClient } from '@prisma/client';

export class SocietyService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).societies.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: {
    name: string;
    address?: string;
    city?: string;
    state?: string;
    pincode?: string;
    builder_id?: number;
  }) {
    return (this.prisma as any).societies.create({
      data: {
        society_name: data.name,
        address: data.address,
        pincode: data.pincode,
        builder_id: data.builder_id !== undefined ? String(data.builder_id) : undefined,
      },
    });
  }

  async update(id: number, data: {
    name?: string;
    address?: string;
    city?: string;
    state?: string;
    pincode?: string;
    builder_id?: number;
  }) {
    return (this.prisma as any).societies.update({
      where: { id },
      data: {
        society_name: data.name,
        address: data.address,
        pincode: data.pincode,
        builder_id: data.builder_id !== undefined ? String(data.builder_id) : undefined,
      },
    });
  }

  async delete(id: number) {
    await (this.prisma as any).societies.delete({ where: { id } });
    return { message: 'Society deleted successfully' };
  }
}
