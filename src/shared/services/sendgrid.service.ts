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
