import { prisma } from '../../config/database';

export class EmployeeService {
  async list(filters?: any) {
    const where: any = { is_admin: 0, is_sub_admin: 0 };
    if (filters?.search) {
      where.OR = [
        { name: { contains: filters.search } },
        { email: { contains: filters.search } },
      ];
    }
    return (prisma as any).user.findMany({ where });
  }

  async create(data: any) {
    return (prisma as any).user.create({
      data: { ...data, is_admin: 0, is_sub_admin: 0 },
    });
  }

  async update(id: number, data: any) {
    return (prisma as any).user.update({
      where: { id },
      data,
    });
  }

  async getById(id: number) {
    return (prisma as any).user.findUnique({ where: { id } });
  }

  async toggleStatus(id: number) {
    const employee = await (prisma as any).user.findUnique({ where: { id } });
    if (!employee) throw new Error('Employee not found');
    const newStatus = employee.status === 1 ? 0 : 1;
    return (prisma as any).user.update({
      where: { id },
      data: { status: newStatus },
    });
  }

  async getUserMap(id: number) {
    return (prisma as any).user.findUnique({
      where: { id },
      select: { id: true, name: true, email: true, phone: true },
    });
  }
}
