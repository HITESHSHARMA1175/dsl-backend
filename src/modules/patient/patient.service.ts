import { AppError } from '../../shared/utils/appError';

export class PatientService {
  constructor(private prisma: any) {}

  async create(data: any) {
    const patient = await this.prisma.patients.create({
      data: {
        title: data.title,
        first_name: data.first_name,
        last_name: data.last_name,
        email: data.email,
        mobile: data.mobile,
        dob: data.dob ? new Date(data.dob) : undefined,
        gender: data.gender,
        sex: data.sex,
        marital_status: data.marital_status,
        address1: data.address1,
        address2: data.address2,
        city: data.city,
        country: data.country,
        pincode: data.pincode,
      },
    });

    return patient;
  }

  async update(id: number, data: any) {
    const existing = await this.prisma.patients.findUnique({
      where: { id: BigInt(id) },
    });

    if (!existing) {
      throw new AppError(404, 'Patient not found');
    }

    const patient = await this.prisma.patients.update({
      where: { id: BigInt(id) },
      data: {
        ...(data.title !== undefined && { title: data.title }),
        ...(data.first_name !== undefined && { first_name: data.first_name }),
        ...(data.last_name !== undefined && { last_name: data.last_name }),
        ...(data.email !== undefined && { email: data.email }),
        ...(data.mobile !== undefined && { mobile: data.mobile }),
        ...(data.dob !== undefined && { dob: data.dob ? new Date(data.dob) : null }),
        ...(data.gender !== undefined && { gender: data.gender }),
        ...(data.sex !== undefined && { sex: data.sex }),
        ...(data.marital_status !== undefined && { marital_status: data.marital_status }),
        ...(data.address1 !== undefined && { address1: data.address1 }),
        ...(data.address2 !== undefined && { address2: data.address2 }),
        ...(data.city !== undefined && { city: data.city }),
        ...(data.country !== undefined && { country: data.country }),
        ...(data.pincode !== undefined && { pincode: data.pincode }),
      },
    });

    return patient;
  }

  async list(searchText?: string) {
    const where: any = {};

    if (searchText) {
      where.OR = [
        { first_name: { contains: searchText } },
        { last_name: { contains: searchText } },
        { email: { contains: searchText } },
        { mobile: { contains: searchText } },
      ];
    }

    const patients = await this.prisma.patients.findMany({
      where,
      orderBy: { id: 'desc' },
      take: 100,
    });

    return patients;
  }

  async getById(id: number) {
    const patient = await this.prisma.patients.findUnique({
      where: { id: BigInt(id) },
    });

    if (!patient) {
      throw new AppError(404, 'Patient not found');
    }

    return patient;
  }

  async getTimeline(patientId: number) {
    const appointments = await this.prisma.appointments.findMany({
      where: { app_patient: String(patientId) },
      orderBy: { created_at: 'desc' },
    });

    return appointments;
  }

  async saveMedicalHistory(patientId: number, historyIds: number[], addBy: number) {
    // Create patient_medical_histories record with JSON array of history IDs
    const record = await this.prisma.patient_medical_histories.create({
      data: {
        patient_id: patientId,
        medical_history: historyIds,
        add_by: addBy,
      },
    });

    return record;
  }

  async getMedicalHistory(patientId: number) {
    const records = await this.prisma.patient_medical_histories.findMany({
      where: { patient_id: patientId },
      orderBy: { id: 'desc' },
    });

    return records;
  }

  async getFinance(patientId: number) {
    // Appointments and any related orders give the patient's financial picture.
    const appointments = await this.prisma.appointments.findMany({
      where: { app_patient: String(patientId) },
      orderBy: { created_at: 'desc' },
    });

    const totalAppointments = appointments.length;

    return {
      patient_id: patientId,
      total_appointments: totalAppointments,
      appointments,
    };
  }
}
