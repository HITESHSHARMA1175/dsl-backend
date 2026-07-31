import nodemailer from 'nodemailer';
import { env } from '../../config/env';

type OrderEmailItem = {
  product_name?: string | null;
  type?: string | null;
  qty?: number | null;
  price?: number | string | null;
};

type OrderConfirmationEmailData = {
  orderId: number;
  customerName: string;
  email: string;
  phone?: string | null;
  amount: number;
  paymentMethod?: string | null;
  appointmentDate?: string | null;
  appointmentSlot?: string | null;
  items: OrderEmailItem[];
};

function escapeHtml(value: unknown) {
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

export class NodemailerService {
  private transporter = nodemailer.createTransport({
    host: env.SMTP_HOST,
    port: env.SMTP_PORT,
    secure: env.SMTP_SECURE,
    auth: env.SMTP_USER && env.SMTP_PASS
      ? { user: env.SMTP_USER, pass: env.SMTP_PASS }
      : undefined,
  });

  private isConfigured() {
    return Boolean(env.SMTP_HOST && env.SMTP_USER && env.SMTP_PASS);
  }

  async sendOrderConfirmation(data: OrderConfirmationEmailData) {
    if (!this.isConfigured()) {
      console.warn('[mail] SMTP not configured. Skipping order confirmation email.');
      return;
    }

    const itemRows = data.items.map((item) => {
      const qty = Number(item.qty || 1);
      const price = Number(item.price || 0);
      const lineTotal = qty * price;

      return `
        <tr>
          <td style="padding:10px;border-bottom:1px solid #eee;">${escapeHtml(item.product_name || 'Item')}</td>
          <td style="padding:10px;border-bottom:1px solid #eee;">${escapeHtml(item.type || '-')}</td>
          <td style="padding:10px;border-bottom:1px solid #eee;text-align:center;">${qty}</td>
          <td style="padding:10px;border-bottom:1px solid #eee;text-align:right;">GBP ${lineTotal.toFixed(2)}</td>
        </tr>
      `;
    }).join('');

    const appointmentHtml = data.appointmentDate || data.appointmentSlot
      ? `
        <p><strong>Appointment Date:</strong> ${escapeHtml(data.appointmentDate || 'To be confirmed')}</p>
        <p><strong>Appointment Slot:</strong> ${escapeHtml(data.appointmentSlot || 'To be confirmed')}</p>
      `
      : '';

    const html = `
      <div style="font-family:Arial,sans-serif;color:#111;line-height:1.5;">
        <h2>Thank you for your order, ${escapeHtml(data.customerName)}</h2>
        <p>Your order has been received successfully.</p>
        <p><strong>Order ID:</strong> #${data.orderId}</p>
        <p><strong>Payment Method:</strong> ${escapeHtml(data.paymentMethod || 'Pending')}</p>
        ${appointmentHtml}
        <table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-top:16px;">
          <thead>
            <tr style="background:#f8f8f8;">
              <th align="left" style="padding:10px;">Item</th>
              <th align="left" style="padding:10px;">Type</th>
              <th align="center" style="padding:10px;">Qty</th>
              <th align="right" style="padding:10px;">Total</th>
            </tr>
          </thead>
          <tbody>${itemRows}</tbody>
        </table>
        <h3 style="text-align:right;">Order Total: GBP ${Number(data.amount || 0).toFixed(2)}</h3>
        <p>Our team will contact you if anything else is needed.</p>
        <p>${escapeHtml(env.SMTP_FROM_NAME)}</p>
      </div>
    `;

    await this.transporter.sendMail({
      from: `"${env.SMTP_FROM_NAME}" <${env.SMTP_FROM_EMAIL}>`,
      to: data.email,
      subject: `Order Confirmation #${data.orderId} - ${env.SMTP_FROM_NAME}`,
      html,
    });
  }
}
