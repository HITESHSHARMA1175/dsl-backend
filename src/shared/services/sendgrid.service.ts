import axios from 'axios';
import { env } from '../../config/env';

export interface BookingEmailData {
  bookingId: number;
  amount: string;
  date: string;
  time: string;
}

export interface OrderEmailData {
  orderId: number;
  amount: string;
  date: string;
}

export class SendGridService {
  private apiUrl = 'https://api.sendgrid.com/v3/mail/send';

  async sendOtpEmail(to: string, otp: string): Promise<void> {
    const html = `<h2>OTP Verification</h2>
      <p>Your OTP code is: <strong>${otp}</strong></p>
      <p>It expires in 5 minutes.</p>`;
    await this.send(to, 'OTP Verification', html);
  }

  async sendBookingConfirmation(to: string, data: BookingEmailData): Promise<void> {
    const html = `<h2>Booking Confirmed</h2>
      <p>Booking ID: ${data.bookingId}</p>
      <p>Amount: £${data.amount}</p>
      <p>Date: ${data.date}</p>
      <p>Time: ${data.time}</p>`;
    await this.send(to, 'DSL Clinic Booking Confirmation', html);
  }

  async sendOrderConfirmation(to: string, data: OrderEmailData): Promise<void> {
    const html = `<h2>Order Confirmed</h2>
      <p>Order ID: ${data.orderId}</p>
      <p>Amount: £${data.amount}</p>
      <p>Date: ${data.date}</p>`;
    await this.send(to, 'DSL Clinic Order Confirmation', html);
  }

  async sendWelcomeEmail(to: string, name: string): Promise<void> {
    const html = `<h2>Welcome to DSL Clinic, ${name}!</h2>
      <p>Thank you for joining Diamond Skin London. We look forward to helping you look and feel your best.</p>`;
    await this.send(to, 'Welcome to DSL Clinic', html);
  }

  async sendDataImportMail(to: string, data: { type: string; count: number }): Promise<void> {
    const html = `<h2>Data Import Completed</h2>
      <p>Your ${data.type} import has been completed successfully.</p>
      <p>Records imported: ${data.count}</p>`;
    await this.send(to, `${data.type} Import Completed`, html);
  }

  async sendLeadImportMail(to: string, data: { count: number; source?: string }): Promise<void> {
    const html = `<h2>Lead Import Completed</h2>
      <p>Your lead import has been completed successfully.</p>
      <p>Leads imported: ${data.count}</p>
      ${data.source ? `<p>Source: ${data.source}</p>` : ''}`;
    await this.send(to, 'Lead Import Completed', html);
  }

  async sendLeadStatusChangeMail(to: string, data: { leadId: number; name: string; oldStatus: string; newStatus: string }): Promise<void> {
    const html = `<h2>Lead Status Changed</h2>
      <p>Lead "${data.name}" (ID: ${data.leadId}) status has been updated.</p>
      <p>From: ${data.oldStatus} → To: ${data.newStatus}</p>`;
    await this.send(to, 'Lead Status Updated', html);
  }

  async sendForgotPasswordMail(to: string, data: { name: string; password: string }): Promise<void> {
    const html = `<h2>Password Reset</h2>
      <p>Hello ${data.name},</p>
      <p>Your password has been reset. Your new password is: <strong>${data.password}</strong></p>
      <p>Please login and change your password immediately.</p>`;
    await this.send(to, 'Password Reset - DSL Clinic', html);
  }

  async sendDataStatusChangeMail(to: string, data: { dataId: number; name: string; oldStatus: string; newStatus: string }): Promise<void> {
    const html = `<h2>Data Status Changed</h2>
      <p>Record "${data.name}" (ID: ${data.dataId}) status has been updated.</p>
      <p>From: ${data.oldStatus} → To: ${data.newStatus}</p>`;
    await this.send(to, 'Data Status Updated', html);
  }

  async sendBirthdayMail(to: string, name: string): Promise<void> {
    const html = `<h2>Happy Birthday, ${name}! 🎉</h2>
      <p>Wishing you a wonderful day from all of us at Diamond Skin London.</p>
      <p>Enjoy a special treat on your next visit!</p>`;
    await this.send(to, 'Happy Birthday from DSL Clinic', html);
  }

  private async send(to: string, subject: string, htmlContent: string): Promise<void> {
    await axios.post(
      this.apiUrl,
      {
        personalizations: [{ to: [{ email: to }] }],
        from: { email: env.SENDGRID_FROM_EMAIL, name: env.SENDGRID_FROM_NAME },
        subject,
        content: [{ type: 'text/html', value: htmlContent }],
      },
      {
        headers: {
          Authorization: `Bearer ${env.SENDGRID_API_KEY}`,
          'Content-Type': 'application/json',
        },
      }
    );
  }
}
