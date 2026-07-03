import { PrismaClient } from '@prisma/client';

interface Slot {
  id: number;
  slot_start: string;   // "HH:mm"
  slot_end: string;     // "HH:mm"
  formatted_date: string;
}

export class SlotService {
  private static readonly START_HOUR = 10;
  private static readonly END_HOUR = 17;
  private static readonly INTERVAL_MINUTES = 10;

  constructor(private prisma: PrismaClient) {}

  async getAvailableSlots(
    professionalId: number,
    date: string,
    totalServiceDuration: number
  ): Promise<Slot[]> {
    // Generate all possible 10-minute slots from 10:00 to 17:00
    const allSlots = this.generateTimeSlots();

    // Fetch existing bookings for this professional on this date
    const existingBookings = await this.prisma.kiBooking.findMany({
      where: { profession_id: professionalId, slot_date: date },
      select: { slot_time: true, total_service_duration: true },
    });

    // Filter out overlapping slots
    const availableSlots = allSlots.filter((slot) => {
      return !existingBookings.some((booking) =>
        this.hasOverlap(
          slot.slot_start,
          totalServiceDuration,
          booking.slot_time!,
          Number(booking.total_service_duration)
        )
      );
    });

    return availableSlots.map((slot, index) => ({
      id: index + 1,
      slot_start: slot.slot_start,
      slot_end: this.addMinutes(slot.slot_start, totalServiceDuration),
      formatted_date: date,
    }));
  }

  private generateTimeSlots(): { slot_start: string }[] {
    const slots: { slot_start: string }[] = [];
    for (let hour = SlotService.START_HOUR; hour < SlotService.END_HOUR; hour++) {
      for (let min = 0; min < 60; min += SlotService.INTERVAL_MINUTES) {
        slots.push({
          slot_start: `${String(hour).padStart(2, '0')}:${String(min).padStart(2, '0')}`,
        });
      }
    }
    return slots;
  }

  private hasOverlap(
    slotStart: string,
    slotDuration: number,
    bookingStart: string,
    bookingDuration: number
  ): boolean {
    const slotStartMin = this.timeToMinutes(slotStart);
    const slotEndMin = slotStartMin + slotDuration;
    const bookingStartMin = this.timeToMinutes(bookingStart);
    const bookingEndMin = bookingStartMin + bookingDuration;
    return slotStartMin < bookingEndMin && bookingStartMin < slotEndMin;
  }

  private timeToMinutes(time: string): number {
    const [h, m] = time.split(':').map(Number);
    return h * 60 + m;
  }

  private addMinutes(time: string, minutes: number): string {
    const total = this.timeToMinutes(time) + minutes;
    return `${String(Math.floor(total / 60)).padStart(2, '0')}:${String(total % 60).padStart(2, '0')}`;
  }
}
