import { AppError } from '../../shared/utils/appError';

export class OrderService {
  constructor(private prisma: any) {}

  private formatOrder(order: any) {
    if (!order) return order;

    let cartDetails = order.cart_details;
    if (typeof cartDetails === 'string') {
      try { cartDetails = JSON.parse(cartDetails); } catch { cartDetails = []; }
    }

    const items = Array.isArray(cartDetails) ? cartDetails : (cartDetails?.items || []);
    const appointment_date = cartDetails?.appointment_date || null;
    const appointment_slot = cartDetails?.appointment_slot || null;

    return {
      ...order,
      id: Number(order.id),
      user_id: order.user_id ? Number(order.user_id) : null,
      order_amount: order.order_amount !== null && order.order_amount !== undefined ? Number(order.order_amount) : 0,
      cart_details: cartDetails,
      items,
      appointment_date,
      appointment_slot,
    };
  }

  async list(page = 1, perPage = 10, filters?: { search?: string; status?: string; user_id?: number }) {
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

    if (filters?.user_id) {
      where.user_id = filters.user_id;
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

    return { items: (items as any[]).map(i => this.formatOrder(i)), total };
  }

  async getById(id: number) {
    const order = await this.prisma.order.findUnique({ where: { id } });
    if (!order) {
      throw new AppError(404, 'Order not found');
    }
    return this.formatOrder(order);
  }

  async updateStatus(id: number, orderStatus: string) {
    const existing = await this.prisma.order.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Order not found');
    }
    const updated = await this.prisma.order.update({
      where: { id },
      data: { order_status: orderStatus },
    });
    return this.formatOrder(updated);
  }

  async toggleStatus(id: number) {
    const record = await this.prisma.order.findUnique({ where: { id } });
    if (!record) {
      throw new AppError(404, 'Order not found');
    }
    const newStatus = record.status === 1 ? 0 : 1;
    const updated = await this.prisma.order.update({
      where: { id },
      data: { status: newStatus },
    });
    return this.formatOrder(updated);
  }

  async delete(id: number) {
    const existing = await this.prisma.order.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Order not found');
    }
    await this.prisma.order.delete({ where: { id } });
    return { message: 'Order deleted successfully' };
  }

  /** Customer: get their own orders (by customer ID, email, or mobile with search & status filters) */
  async getMyOrders(customerId: number, page = 1, perPage = 10, filters?: { search?: string; status?: string }) {
    const customer = await this.prisma.customer.findUnique({ where: { id: customerId } });

    const userConditions: any[] = [{ user_id: customerId }];
    if (customer?.email) {
      userConditions.push({ billing_email: customer.email });
    }
    if (customer?.mobile) {
      userConditions.push({ billing_phone: customer.mobile });
    }

    const andConditions: any[] = [
      { OR: userConditions }
    ];

    if (filters?.status && filters.status !== 'All') {
      andConditions.push({ order_status: filters.status });
    }

    if (filters?.search && filters.search.trim()) {
      const rawSearch = filters.search.trim();
      const searchClean = rawSearch.replace(/^#/, '');
      const searchNum = Number(searchClean);
      const isNum = !isNaN(searchNum) && searchClean.length > 0;

      const searchOrs: any[] = [
        { billing_first_name: { contains: rawSearch } },
        { billing_last_name: { contains: rawSearch } },
        { billing_email: { contains: rawSearch } },
        { billing_phone: { contains: rawSearch } },
      ];

      if (isNum) {
        searchOrs.push({ id: searchNum });
      }

      andConditions.push({ OR: searchOrs });
    }

    const where = { AND: andConditions };
    const [items, total] = await Promise.all([
      this.prisma.order.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.order.count({ where }),
    ]);
    return { items: (items as any[]).map(i => this.formatOrder(i)), total };
  }
}
