import { AppError } from '../../shared/utils/appError';

export class AttendanceService {
  constructor(private prisma: any) {}

  async markAttendance(userId: number, data: any) {
    const attendance = await this.prisma.attendances.create({
      data: {
        user_id: userId,
        is_present: '1',
        current_location: data.current_location,
        attendance_date: new Date(data.attendance_date || new Date().toISOString().split('T')[0]),
        attendance_time: data.attendance_time
          ? new Date(`1970-01-01T${data.attendance_time}`)
          : new Date(`1970-01-01T${new Date().toTimeString().split(' ')[0]}`),
      },
    });

    return { attendance_id: attendance.id };
  }

  async punchOut(attendanceId: number, data: any) {
    const existing = await this.prisma.attendances.findUnique({
      where: { id: attendanceId },
    });

    if (!existing) {
      throw new AppError(404, 'Attendance record not found');
    }

    const attendance = await this.prisma.attendances.update({
      where: { id: attendanceId },
      data: {
        updated_at: new Date(),
      },
    });

    return attendance;
  }

  async getMyAttendance(userId: number, month?: number, year?: number) {
    const where: any = { user_id: userId };

    if (month && year) {
      const startDate = new Date(year, month - 1, 1);
      const endDate = new Date(year, month, 0);
      where.attendance_date = {
        gte: startDate,
        lte: endDate,
      };
    }

    const records = await this.prisma.attendances.findMany({
      where,
      orderBy: { attendance_date: 'desc' },
    });

    return records;
  }

  async getAllAttendance(month?: number, year?: number) {
    const where: any = {};

    if (month && year) {
      const startDate = new Date(year, month - 1, 1);
      const endDate = new Date(year, month, 0);
      where.attendance_date = {
        gte: startDate,
        lte: endDate,
      };
    }

    const records = await this.prisma.attendances.findMany({
      where,
      orderBy: { attendance_date: 'desc' },
    });

    return records;
  }

  async addLeave(userId: number, data: { leave_type: string; day_type?: string; leave_date: string }) {
    const leave = await this.prisma.leaves.create({
      data: {
        user_id: userId,
        leave_type: data.leave_type,
        day_type: data.day_type || 'Full Day',
        leave_date: new Date(data.leave_date),
      },
    });
    return leave;
  }

  async getMyLeaves(userId: number) {
    return this.prisma.leaves.findMany({
      where: { user_id: userId },
      orderBy: { id: 'desc' },
    });
  }
}
