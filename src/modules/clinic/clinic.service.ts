import { PrismaClient } from '@prisma/client';

export class ClinicService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return this.prisma.clinic.findMany();
  }

  async create(data: {
    name: string;
    address?: string;
    city?: string;
    postcode?: string;
    phone?: string;
    email?: string;
    status?: string;
  }) {
    return this.prisma.clinic.create({ data });
  }

  async update(id: number, data: {
    name?: string;
    address?: string;
    city?: string;
    postcode?: string;
    phone?: string;
    email?: string;
    status?: string;
  }) {
    return this.prisma.clinic.update({ where: { id }, data });
  }

  async delete(id: number) {
    await this.prisma.clinic.delete({ where: { id } });
    return { message: 'Clinic deleted successfully' };
  }

  async toggleStatus(id: number) {
    const record = await this.prisma.clinic.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.clinic.update({
      where: { id },
      data: { status: newStatus },
    });
  }

  // ==================== MOBILE (clinic detail) ENDPOINTS ====================

  async getInfo(id: number) {
    const clinic = await (this.prisma as any).clinic.findUnique({ where: { id } });
    if (!clinic) {
      const { AppError } = require('../../shared/utils/appError');
      throw new AppError(404, 'Clinic not found');
    }
    return clinic;
  }

  /** Hygiene/general info card for the mobile app. */
  async getHxg(id: number) {
    const clinic = await (this.prisma as any).clinic.findUnique({
      where: { id },
    });
    if (!clinic) return null;
    return {
      id: clinic.id,
      clinic_name: clinic.clinic_name,
      profile: clinic.profile,
      address: clinic.address,
      google_map: clinic.google_map,
      metro_name: clinic.metro_name,
      metro_text: clinic.metro_text,
      railway_name: clinic.railway_name,
      railway_text: clinic.railway_text,
    };
  }

  /** Opening hours for the mobile app. */
  async getTime(id: number) {
    const clinic = await (this.prisma as any).clinic.findUnique({ where: { id } });
    if (!clinic) return null;
    return {
      mon_to_fry: clinic.mon_to_fry,
      clinic_start_time: clinic.clinic_start_time,
      clinic_close_time: clinic.clinic_close_time,
      sat: clinic.sat,
      sat_start_time: clinic.sat_start_time,
      sat_close_time: clinic.sat_close_time,
      sun: clinic.sun,
      sun_start_time: clinic.sun_start_time,
      sun_close_time: clinic.sun_close_time,
      clinic_timezone: clinic.clinic_timezone,
    };
  }

  /** Clinic rooms (sourced from the "Room" master head). */
  async getRooms() {
    const master = await (this.prisma as any).masters.findFirst({ where: { MasterHead: 'Room' } });
    if (!master) return [];
    return (this.prisma as any).masterValue.findMany({
      where: { MasterHead: Number(master.id), status: 1 },
      orderBy: { id: 'asc' },
    });
  }

  /** Clinic equipment (sourced from the "Equipment" master head). */
  async getEquipments() {
    const master = await (this.prisma as any).masters.findFirst({ where: { MasterHead: 'Equipment' } });
    if (!master) return [];
    return (this.prisma as any).masterValue.findMany({
      where: { MasterHead: Number(master.id), status: 1 },
      orderBy: { id: 'asc' },
    });
  }

  /** Finance summary for a clinic (orders placed). */
  async getFinance() {
    const [orderCount, bookingCount] = await Promise.all([
      (this.prisma as any).order.count(),
      (this.prisma as any).kiBooking.count(),
    ]);
    return { total_orders: orderCount, total_bookings: bookingCount };
  }
}
