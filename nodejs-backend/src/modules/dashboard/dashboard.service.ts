import { prisma } from '../../config/database';

export class DashboardService {
  async getStats() {
    const [
      users,
      bookings,
      orders,
      consultations,
      categories,
      services,
      addons,
      treatments,
      professionals,
    ] = await Promise.all([
      (prisma as any).user.count(),
      (prisma as any).booking.count(),
      (prisma as any).order.count(),
      (prisma as any).consultation_form.count(),
      (prisma as any).property_category.count(),
      (prisma as any).service.count(),
      (prisma as any).addon.count(),
      (prisma as any).treatment.count(),
      (prisma as any).professional.count(),
    ]);

    return {
      users,
      bookings,
      orders,
      consultations,
      categories,
      services,
      addons,
      treatments,
      professionals,
    };
  }
}
