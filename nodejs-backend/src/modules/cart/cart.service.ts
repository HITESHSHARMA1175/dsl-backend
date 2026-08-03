import { AppError } from '../../shared/utils/appError';
import { NodemailerService } from '../../shared/services/nodemailer.service';

/**
 * Guest shopping cart management.
 * Maps to the `guest_carts` table. Cart items are scoped by a `session`
 * identifier (falling back to the client IP address when no session is given).
 */
export class CartService {
  private mailer = new NodemailerService();

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
      where: {
        session: sessionKey,
        product_id: data.product_id,
        type: data.type || null,
      },
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
    let { items, total } = await this.list(sessionKey);

    console.log('[checkout] sessionKey:', sessionKey, '| DB items count:', items?.length ?? 0, '| billing.items count:', billing?.items?.length ?? 'none');

    // Fallback: If DB cart for sessionKey is empty but items were passed in checkout payload,
    // use them directly without inserting into guest_carts (avoids BigInt product_id issues).
    if ((!items || items.length === 0) && Array.isArray(billing?.items) && billing.items.length > 0) {
      console.log('[checkout] Using fallback items from payload:', JSON.stringify(billing.items));
      items = billing.items.map((item: any) => ({
        id: item.id ?? null,
        product_id: String(item.product_id || item.dbId || item.id || 0),
        product_name: item.name || item.product_name || 'Item',
        price: Number(item.price || item.priceNum || 0),
        qty: Number(item.quantity || item.qty || 1),
        type: item.type || 'Product',
        image: item.image || null,
        session: sessionKey,
      }));
      total = items.reduce((sum: number, item: any) => sum + Number(item.price) * Number(item.qty), 0);
      console.log('[checkout] Fallback items built, count:', items.length, '| total:', total);
    }

    if (!items || !items.length) {
      console.log('[checkout] THROWING Cart is empty — no DB items and no fallback items');
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

    try {
      await this.mailer.sendOrderConfirmation({
        orderId: Number(order.id),
        customerName: [billing.first_name, billing.last_name].filter(Boolean).join(' ') || 'Customer',
        email: billing.email,
        phone: billing.phone || null,
        amount: Number(order.order_amount || total || 0),
        paymentMethod: order.payment_method,
        appointmentDate: billing.appointment_date || null,
        appointmentSlot: billing.appointment_slot || null,
        items,
      });
    } catch (error) {
      console.error('[mail] Failed to send order confirmation email', error);
    }

    // Empty the cart after creating the order
    await this.clear(sessionKey);

    return order;
  }
}
