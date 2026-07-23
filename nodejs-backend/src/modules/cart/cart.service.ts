import { AppError } from '../../shared/utils/appError';

/**
 * Guest shopping cart management.
 * Maps to the `guest_carts` table. Cart items are scoped by a `session`
 * identifier (falling back to the client IP address when no session is given).
 */
export class CartService {
  constructor(private prisma: any) {}

  async list(sessionKey: string) {
    const items = await this.prisma.guest_carts.findMany({
      where: { session: sessionKey },
      orderBy: { id: 'desc' },
    });

    const total = items.reduce(
      (sum: number, item: any) => sum + Number(item.price) * item.qty,
      0
    );
    const count = items.reduce((sum: number, item: any) => sum + item.qty, 0);

    return { items, total, count };
  }

  async add(sessionKey: string, ipAddress: string, data: any) {
    // If product already in cart for this session, increment qty
    const existing = await this.prisma.guest_carts.findFirst({
      where: { session: sessionKey, product_id: data.product_id },
    });

    if (existing) {
      return this.prisma.guest_carts.update({
        where: { id: existing.id },
        data: { qty: existing.qty + (data.qty || 1) },
      });
    }

    return this.prisma.guest_carts.create({
      data: {
        session: sessionKey,
        ip_address: ipAddress,
        product_id: data.product_id,
        product_name: data.product_name,
        price: data.price ?? 0,
        qty: data.qty || 1,
        image: data.image || null,
        type: data.type || null,
      },
    });
  }

  async updateQty(id: number, qty: number) {
    const existing = await this.prisma.guest_carts.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Cart item not found');
    }
    if (qty <= 0) {
      await this.prisma.guest_carts.delete({ where: { id } });
      return { message: 'Cart item removed' };
    }
    return this.prisma.guest_carts.update({ where: { id }, data: { qty } });
  }

  async remove(id: number) {
    const existing = await this.prisma.guest_carts.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Cart item not found');
    }
    await this.prisma.guest_carts.delete({ where: { id } });
    return { message: 'Cart item removed successfully' };
  }

  async clear(sessionKey: string) {
    await this.prisma.guest_carts.deleteMany({ where: { session: sessionKey } });
    return { message: 'Cart cleared successfully' };
  }

  /**
   * Convert the current cart into an order record.
   */
  async checkout(sessionKey: string, billing: any) {
    const { items, total } = await this.list(sessionKey);
    if (!items.length) {
      throw new AppError(400, 'Cart is empty');
    }

    const order = await this.prisma.order.create({
      data: {
        user_id: billing.user_id || null,
        billing_first_name: billing.first_name,
        billing_last_name: billing.last_name || null,
        billing_email: billing.email,
        billing_phone: billing.phone,
        billing_address_1: billing.address || null,
        billing_city: billing.city || null,
        billing_postcode: billing.postcode || null,
        billing_country: billing.country || null,
        order_amount: Math.round(total),
        payment_method: billing.payment_method || 'cod',
        cart_details: {
          items,
          appointment_date: billing.appointment_date || null,
          appointment_slot: billing.appointment_slot || null,
        },
        order_status: 'Pending',
        status: 1,
      },
    });

    // Empty the cart after creating the order
    await this.clear(sessionKey);

    return order;
  }
}
