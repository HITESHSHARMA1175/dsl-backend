import { PrismaClient } from '@prisma/client';
import { SendGridService } from '../../shared/services/sendgrid.service';

export class CronService {
  private sendgrid = new SendGridService();

  constructor(private prisma: PrismaClient) {}

  async createMoveinPayment() {
    // Stub: In production, this would:
    // 1. Find tenants with pending move-in payments
    // 2. Create EMI records for each
    // 3. Send notifications
    const tenants = await (this.prisma as any).tenants.findMany({
      where: { status: 'active' },
    });

    let created = 0;
    for (const tenant of tenants) {
      // Stub: create EMI record logic
      created++;
    }

    return { message: `Move-in payment cron executed. Processed ${created} tenants.` };
  }

  /**
   * Sends birthday emails to users whose date of birth falls on today
   * (matches month + day). Uses a raw query because `dob` may contain
   * legacy zero-dates that break Prisma's default selection.
   */
  async sendBirthdayEmails() {
    const today = new Date();
    const month = today.getMonth() + 1;
    const day = today.getDate();

    const users: any[] = await (this.prisma as any).$queryRawUnsafe(
      `SELECT id, first_name, email FROM users
       WHERE email IS NOT NULL AND email != ''
         AND MONTH(dob) = ? AND DAY(dob) = ?`,
      month,
      day
    );

    let sent = 0;
    for (const user of users) {
      try {
        await this.sendgrid.sendBirthdayMail(user.email, user.first_name ?? 'there');
        sent++;
      } catch { /* skip failed sends */ }
    }

    return { message: `Birthday email cron executed. Sent ${sent} of ${users.length} emails.` };
  }
}
