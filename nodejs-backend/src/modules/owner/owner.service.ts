import { PrismaClient } from '@prisma/client';

export class OwnerService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return (this.prisma as any).owners.findMany({ orderBy: { id: 'desc' } });
  }

  async create(data: { name: string; email?: string; phone?: string; address?: string }) {
    const [first_name, ...rest] = data.name.split(' ');
    return (this.prisma as any).owners.create({
      data: {
        first_name,
        last_name: rest.join(' ') || undefined,
        email: data.email,
        mobile_no: data.phone,
        per_address: data.address,
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
    return (this.prisma as any).owners.update({
      where: { id },
      data: {
        first_name,
        last_name,
        email: data.email,
        mobile_no: data.phone,
        per_address: data.address,
      },
    });
  }

  async delete(id: number) {
    await (this.prisma as any).owners.delete({ where: { id } });
    return { message: 'Owner deleted successfully' };
  }
}
