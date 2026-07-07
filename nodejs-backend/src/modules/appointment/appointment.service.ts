import { AppError } from '../../shared/utils/appError';

export class AppointmentService {
  constructor(private prisma: any) {}

  async create(data: any, addBy: number) {
    const appointment = await this.prisma.appointments.create({
      data: {
        clinician_id: data.clinician_id,
        title: data.title,
        app_date: data.app_date,
        app_duration: data.app_duration ? new Date(`1970-01-01T${data.app_duration}`) : undefined,
        total_service_duration: data.total_service_duration,
        app_time_id: data.app_time_id,
        app_time_start: data.app_time_start,
        app_time_end: data.app_time_end,
        app_purpose: data.app_purpose,
        app_patient: data.app_patient,
        app_type: data.app_type,
        virtual_call: data.virtual_call,
        treatement_type: data.treatement_type,
        treatement: data.treatement,
        room: data.room,
        equipment: data.equipment,
        app_notes: data.app_notes,
        add_by: String(addBy),
      },
    });

    // Create initial journey entry
    if (data.app_notes) {
      await this.prisma.appointment_journeys.create({
        data: {
          appointment: appointment.id,
          notes: data.app_notes,
          add_by: addBy,
        },
      });
    }

    return { appointment_id: appointment.id };
  }

  async list(page = 1, perPage = 10) {
    const [items, total] = await Promise.all([
      this.prisma.appointments.findMany({
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { created_at: 'desc' },
      }),
      this.prisma.appointments.count(),
    ]);

    return { items, total };
  }

  async getById(id: number) {
    const appointment = await this.prisma.appointments.findUnique({
      where: { id },
    });

    if (!appointment) {
      throw new AppError(404, 'Appointment not found');
    }

    // Get journey notes
    const notes = await this.prisma.appointment_journeys.findMany({
      where: { appointment: id },
      orderBy: { id: 'desc' },
    });

    return { ...appointment, notes };
  }

  async addNotes(appointmentId: number, notes: string, addBy: number) {
    const appointment = await this.prisma.appointments.findUnique({
      where: { id: appointmentId },
    });

    if (!appointment) {
      throw new AppError(404, 'Appointment not found');
    }

    const journey = await this.prisma.appointment_journeys.create({
      data: {
        appointment: appointmentId,
        notes,
        add_by: addBy,
      },
    });

    return { notes_id: journey.id };
  }

  async addLogs(appointmentId: number, logData: any, addBy: number) {
    const appointment = await this.prisma.appointments.findUnique({
      where: { id: appointmentId },
    });

    if (!appointment) {
      throw new AppError(404, 'Appointment not found');
    }

    const log = await this.prisma.appointment_logs.create({
      data: {
        appointment: appointmentId,
        appointment_action: logData.appointment_action,
        add_by: addBy,
      },
    });

    return {
      appointment_action_id: log.id,
      appointment_action: log.appointment_action,
      created_at: log.created_at,
    };
  }
}
