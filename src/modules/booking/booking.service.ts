import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';
import { SendGridService } from '../../shared/services/sendgrid.service';

export class BookingService {
  private sendGridService: SendGridService;

  constructor(private prisma: PrismaClient) {
    this.sendGridService = new SendGridService();
  }

  async create(data: {
    service_id: string;
    profession_id: number;
    slot_id: number;
    slot_date: string;
    first_name: string;
    last_name: string;
    email: string;
    mobile: string;
    addon_id?: string;
    total_service_duration?: number;
    total_addon_duration?: number;
    slot_time?: string;
    clinic_id?: number;
  }) {
    // Find or create Customer by email + mobile
    let customer = await this.prisma.customer.findFirst({
      where: {
        OR: [{ email: data.email }, { mobile: data.mobile }],
      },
    });

    if (!customer) {
      customer = await this.prisma.customer.create({
        data: {
          first_name: data.first_name,
          last_name: data.last_name,
          email: data.email,
          mobile: data.mobile,
        },
      });
    }

    // Create KiBooking record
    const booking = await this.prisma.kiBooking.create({
      data: {
        user_id: Number(customer.id),
        service_id: data.service_id,
        profession_id: data.profession_id,
        slot_id: data.slot_id,
        slot_date: data.slot_date,
        slot_time: data.slot_time,
        first_name: data.first_name,
        last_name: data.last_name,
        email: data.email,
        mobile: data.mobile,
        addon_id: data.addon_id,
        total_service_duration: data.total_service_duration?.toString(),
        total_addon_duration: data.total_addon_duration?.toString(),
        clinic_id: data.clinic_id?.toString(),
        status: 1,
      },
    });

    // Send confirmation email via SendGrid
    try {
      await this.sendGridService.sendBookingConfirmation(data.email, {
        bookingId: Number(booking.id),
        amount: '0.00',
        date: data.slot_date,
        time: data.slot_time || '',
      });
    } catch (error) {
      // Log but don't fail the booking if email fails
      console.error('Failed to send booking confirmation email:', error);
    }

    return { booking_id: booking.id };
  }

  async list(page = 1, perPage = 10) {
    const [items, total] = await Promise.all([
      this.prisma.kiBooking.findMany({
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { created_at: 'desc' },
      }),
      this.prisma.kiBooking.count(),
    ]);

    return { items: await this.attachRelations(items), total };
  }

  /**
   * KiBooking has no Prisma relations to Customer/Professional (schema was
   * pulled from legacy MySQL with no FKs), so join them manually by id.
   */
  private async attachRelations<T extends { user_id: number | null; profession_id: number | null }>(
    bookings: T[]
  ) {
    const customerIds = [...new Set(bookings.map((b) => b.user_id).filter((id): id is number => id !== null))];
    const professionalIds = [
      ...new Set(bookings.map((b) => b.profession_id).filter((id): id is number => id !== null)),
    ];

    const [customers, professionals] = await Promise.all([
      customerIds.length
        ? this.prisma.customer.findMany({ where: { id: { in: customerIds.map((id) => BigInt(id)) } } })
        : Promise.resolve([]),
      professionalIds.length
        ? this.prisma.professional.findMany({ where: { id: { in: professionalIds } } })
        : Promise.resolve([]),
    ]);

    const customerById = new Map(customers.map((c) => [c.id.toString(), c]));
    const professionalById = new Map(professionals.map((p) => [p.id, p]));

    return bookings.map((booking) => ({
      ...booking,
      customer: booking.user_id !== null ? customerById.get(booking.user_id.toString()) ?? null : null,
      professional: booking.profession_id !== null ? professionalById.get(booking.profession_id) ?? null : null,
    }));
  }

  /**
   * List web-submitted bookings (is_web = 1). Avoids relation includes and
   * created_at ordering to sidestep legacy data issues.
   */
  async listWeb(page = 1, perPage = 10) {
    const where = { is_web: 1 };
    const [items, total] = await Promise.all([
      (this.prisma as any).kiBooking.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      (this.prisma as any).kiBooking.count({ where }),
    ]);

    return { items, total };
  }

  async search(searchText: string) {
    const items = await this.prisma.kiBooking.findMany({
      where: {
        first_name: { contains: searchText },
      },
    });

    return this.attachRelations(items);
  }

  async getById(id: number) {
    const booking = await this.prisma.kiBooking.findUnique({
      where: { id },
    });

    if (!booking) {
      throw new AppError(404, 'Booking not found');
    }

    const [withRelations] = await this.attachRelations([booking]);
    return withRelations;
  }

  async updateStatus(id: number, status: number) {
    const existing = await this.prisma.kiBooking.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Booking not found');
    }

    const booking = await this.prisma.kiBooking.update({
      where: { id },
      data: { status },
    });

    return booking;
  }
}
