import { AppError } from '../../shared/utils/appError';

export class OrderService {
  constructor(private prisma: any) {}

  async list(page = 1, perPage = 10, filters?: { search?: string; status?: string }) {
    const where: any = {};

    if (filters?.search) {
      where.OR = [
        { billing_first_name: { contains: filters.search } },
        { billing_last_name: { contains: filters.search } },
        { billing_email: { contains: filters.search } },
        { billing_phone: { contains: filters.search } },
      ];
    }

    if (filters?.status) {
      where.order_status = filters.status;
    }

    const [items, total] = await Promise.all([
      this.prisma.order.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.order.count({ where }),
    ]);

    return { items, total };
  }

  async getById(id: number) {
    const order = await this.prisma.order.findUnique({ where: { id } });
    if (!order) {
      throw new AppError(404, 'Order not found');
    }
    return order;
  }

  async updateStatus(id: number, orderStatus: string) {
    const existing = await this.prisma.order.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Order not found');
    }
    return this.prisma.order.update({
      where: { id },
      data: { order_status: orderStatus },
    });
  }

  async toggleStatus(id: number) {
    const record = await this.prisma.order.findUnique({ where: { id } });
    if (!record) {
      throw new AppError(404, 'Order not found');
    }
    const newStatus = record.status === 1 ? 0 : 1;
    return this.prisma.order.update({
      where: { id },
      data: { status: newStatus },
    });
  }

  async delete(id: number) {
    const existing = await this.prisma.order.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Order not found');
    }
    await this.prisma.order.delete({ where: { id } });
    return { message: 'Order deleted successfully' };
  }
}
