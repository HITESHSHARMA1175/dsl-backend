"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.NodemailerService = void 0;
const nodemailer_1 = __importDefault(require("nodemailer"));
const dns_1 = __importDefault(require("dns"));
const env_1 = require("../../config/env");
// Force IPv4 DNS resolution globally — Render free tier has no IPv6 outbound routing.
dns_1.default.setDefaultResultOrder('ipv4first');
function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
class NodemailerService {
    getSmtpConfig() {
        const host = env_1.env.SMTP_HOST || 'smtp.gmail.com';
        const user = env_1.env.SMTP_USER || 'Devolyt.developer@gmail.com';
        const pass = env_1.env.SMTP_PASS || 'mkbeesmbwxidtlud';
        return { host, user, pass };
    }
    createTransporter(port) {
        const { host, user, pass } = this.getSmtpConfig();
        return nodemailer_1.default.createTransport({
            host,
            port,
            secure: port === 465,
            connectionTimeout: 10000,
            greetingTimeout: 10000,
            socketTimeout: 15000,
            lookup: (hostname, _options, callback) => {
                dns_1.default.lookup(hostname, { family: 4 }, callback);
            },
            auth: user && pass ? { user, pass } : undefined,
        });
    }
    isConfigured() {
        const { host, user, pass } = this.getSmtpConfig();
        return Boolean(host && user && pass);
    }
    async sendOrderConfirmation(data) {
        if (!this.isConfigured()) {
            console.warn('[mail] SMTP not configured. Skipping order confirmation email.');
            return;
        }
        const brandName = env_1.env.SMTP_FROM_NAME || 'Diamond Skin London';
        const customerName = escapeHtml(data.customerName || 'Valued Customer');
        const orderId = data.orderId;
        const paymentMethod = escapeHtml(data.paymentMethod || 'Pending');
        const totalAmount = Number(data.amount || 0).toFixed(2);
        const currentDate = new Date().toLocaleDateString('en-GB', {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
        });
        const itemRows = data.items
            .map((item, index) => {
            const qty = Number(item.qty || 1);
            const price = Number(item.price || 0);
            const lineTotal = qty * price;
            const bg = index % 2 === 0 ? '#111A33' : '#15203D';
            return `
          <tr style="background-color: ${bg};">
            <td style="padding: 14px 16px; border-bottom: 1px solid #1F2D54; color: #FFFFFF; font-size: 13px; font-weight: 600;">
              ${escapeHtml(item.product_name || 'Item')}
            </td>
            <td style="padding: 14px 16px; border-bottom: 1px solid #1F2D54; color: #D4AF37; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
              ${escapeHtml(item.type || 'Product')}
            </td>
            <td style="padding: 14px 16px; border-bottom: 1px solid #1F2D54; color: #CBD5E1; font-size: 13px; text-align: center; font-weight: 600;">
              ${qty}
            </td>
            <td style="padding: 14px 16px; border-bottom: 1px solid #1F2D54; color: #FFFFFF; font-size: 13px; text-align: right; font-weight: 700;">
              £${lineTotal.toFixed(2)}
            </td>
          </tr>
        `;
        })
            .join('');
        const appointmentHtml = data.appointmentDate || data.appointmentSlot
            ? `
          <div style="margin-top: 24px; padding: 18px 20px; background: rgba(212, 175, 55, 0.08); border: 1px solid rgba(212, 175, 55, 0.35); border-radius: 8px;">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="color: #D4AF37; font-size: 14px; font-weight: 700; padding-bottom: 8px;">
                  🗓️ Clinic Appointment Schedule
                </td>
              </tr>
              <tr>
                <td style="color: #E2E8F0; font-size: 13px; line-height: 1.6;">
                  <strong>Date:</strong> ${escapeHtml(data.appointmentDate || 'To be confirmed')}<br/>
                  <strong>Time Slot:</strong> ${escapeHtml(data.appointmentSlot || 'To be confirmed')}
                </td>
              </tr>
            </table>
          </div>
        `
            : '';
        const html = `
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation #${orderId}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #070C18; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
  
  <!-- Outer Wrapper Table -->
  <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #070C18; padding: 32px 16px;">
    <tr>
      <td align="center">
        
        <!-- Main Email Container -->
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #111A33; border: 1px solid rgba(212, 175, 55, 0.25); border-radius: 12px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);">
          
          <!-- Header Banner -->
          <tr>
            <td align="center" style="background-color: #0B132B; padding: 32px 24px; border-bottom: 2px solid #D4AF37;">
              <h1 style="margin: 0; color: #D4AF37; font-size: 22px; font-weight: 800; tracking-spacing: 2px; letter-spacing: 2px; text-transform: uppercase;">
                DIAMOND SKIN LONDON
              </h1>
              <p style="margin: 6px 0 0 0; color: #94A3B8; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase;">
                Aesthetic & Medical Clinic
              </p>
            </td>
          </tr>

          <!-- Content Body -->
          <tr>
            <td style="padding: 32px 28px;">
              
              <!-- Greeting & Status Badge -->
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td>
                    <span style="display: inline-block; background-color: rgba(34, 197, 94, 0.15); color: #4ADE80; border: 1px solid rgba(34, 197, 94, 0.4); border-radius: 20px; padding: 6px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                      ✓ Order Received
                    </span>
                    <h2 style="margin: 16px 0 8px 0; color: #FFFFFF; font-size: 20px; font-weight: 700;">
                      Thank you for your order, ${customerName}
                    </h2>
                    <p style="margin: 0; color: #94A3B8; font-size: 14px; line-height: 1.6;">
                      We have received your order details and our team is preparing it for you.
                    </p>
                  </td>
                </tr>
              </table>

              <!-- Order Summary Meta Box -->
              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 24px; background-color: #0B132B; border: 1px solid #1F2D54; border-radius: 8px; padding: 16px 20px;">
                <tr>
                  <td width="50%" style="padding: 4px 0;">
                    <span style="color: #64748B; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Order ID</span><br/>
                    <strong style="color: #D4AF37; font-size: 15px;">#${orderId}</strong>
                  </td>
                  <td width="50%" style="padding: 4px 0; text-align: right;">
                    <span style="color: #64748B; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Date</span><br/>
                    <strong style="color: #E2E8F0; font-size: 14px;">${currentDate}</strong>
                  </td>
                </tr>
                <tr>
                  <td width="50%" style="padding: 8px 0 4px 0;">
                    <span style="color: #64748B; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Payment Method</span><br/>
                    <strong style="color: #E2E8F0; font-size: 13px;">${paymentMethod}</strong>
                  </td>
                  <td width="50%" style="padding: 8px 0 4px 0; text-align: right;">
                    <span style="color: #64748B; font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Customer Email</span><br/>
                    <strong style="color: #E2E8F0; font-size: 13px;">${escapeHtml(data.email)}</strong>
                  </td>
                </tr>
              </table>

              <!-- Appointment Schedule (if available) -->
              ${appointmentHtml}

              <!-- Items Table -->
              <div style="margin-top: 28px;">
                <h3 style="margin: 0 0 12px 0; color: #D4AF37; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                  Order Items
                </h3>
                
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; width: 100%; border-radius: 8px; overflow: hidden; border: 1px solid #1F2D54;">
                  <thead>
                    <tr style="background-color: #1A2544;">
                      <th align="left" style="padding: 12px 16px; color: #94A3B8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #1F2D54;">
                        Item
                      </th>
                      <th align="left" style="padding: 12px 16px; color: #94A3B8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #1F2D54;">
                        Type
                      </th>
                      <th align="center" style="padding: 12px 16px; color: #94A3B8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #1F2D54;">
                        Qty
                      </th>
                      <th align="right" style="padding: 12px 16px; color: #94A3B8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #1F2D54;">
                        Total
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    ${itemRows}
                  </tbody>
                </table>
              </div>

              <!-- Grand Total Summary -->
              <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top: 20px;">
                <tr>
                  <td align="right" style="padding: 12px 16px; background-color: #0B132B; border: 1px solid #1F2D54; border-radius: 8px;">
                    <span style="color: #94A3B8; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                      Total Amount:
                    </span>
                    <span style="color: #D4AF37; font-size: 20px; font-weight: 800; margin-left: 12px;">
                      £${totalAmount}
                    </span>
                  </td>
                </tr>
              </table>

              <!-- Support Note -->
              <p style="margin: 28px 0 0 0; color: #94A3B8; font-size: 13px; line-height: 1.6; border-top: 1px solid #1F2D54; padding-top: 20px;">
                If you have any questions about your order or need to reschedule your appointment, please contact our clinic team at <a href="mailto:${escapeHtml(env_1.env.SMTP_FROM_EMAIL)}" style="color: #D4AF37; text-decoration: none; font-weight: 600;">${escapeHtml(env_1.env.SMTP_FROM_EMAIL)}</a>.
              </p>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="background-color: #0B132B; padding: 24px; border-top: 1px solid #1F2D54;">
              <p style="margin: 0; color: #D4AF37; font-size: 13px; font-weight: 700;">
                ${escapeHtml(brandName)}
              </p>
              <p style="margin: 6px 0 0 0; color: #64748B; font-size: 11px;">
                Premium Skin & Aesthetic Treatments in London
              </p>
              <p style="margin: 12px 0 0 0; color: #475569; font-size: 10px;">
                © ${new Date().getFullYear()} ${escapeHtml(brandName)}. All rights reserved.
              </p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
    `;
        const { user } = this.getSmtpConfig();
        const fromEmail = env_1.env.SMTP_USER || user;
        const mailOptions = {
            from: `"${env_1.env.SMTP_FROM_NAME || 'Diamond Skin London'}" <${fromEmail}>`,
            to: data.email,
            subject: `Order Confirmation #${data.orderId} - ${env_1.env.SMTP_FROM_NAME || 'Diamond Skin London'}`,
            html,
        };
        const portsToTry = [465, Number(env_1.env.SMTP_PORT || 587)];
        const uniquePorts = Array.from(new Set(portsToTry));
        let lastError = null;
        for (const port of uniquePorts) {
            try {
                const transporter = this.createTransporter(port);
                const info = await transporter.sendMail(mailOptions);
                console.log(`[mail] Order confirmation email sent successfully for Order #${data.orderId} via port ${port}. MessageId: ${info.messageId}`);
                return;
            }
            catch (err) {
                console.warn(`[mail] Delivery attempt on port ${port} failed (${err?.code || err?.message}). Retrying if ports left...`);
                lastError = err;
            }
        }
        if (lastError) {
            throw lastError;
        }
    }
}
exports.NodemailerService = NodemailerService;
//# sourceMappingURL=nodemailer.service.js.map