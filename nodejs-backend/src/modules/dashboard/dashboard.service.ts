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
      (prisma as any).kiBooking.count(),
      (prisma as any).order.count(),
      (prisma as any).consultation_forms.count(),
      (prisma as any).propertyCategory.count(),
      (prisma as any).property.count(),
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
