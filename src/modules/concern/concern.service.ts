import { prisma } from '../../config/database';

export class ConcernService {
  async getTypes() {
    return (prisma as any).concerns.findMany();
  }

  async list() {
    return (prisma as any).concerns.findMany();
  }

  async save(patientId: number, concernIds: number[]) {
    // Delete existing concerns for this patient
    await (prisma as any).patient_concerns.deleteMany({
      where: { patient_id: patientId },
    });

    // Insert new concerns
    const data = concernIds.map((concernId: number) => ({
      patient_id: patientId,
      concern_id: concernId,
    }));

    await (prisma as any).patient_concerns.createMany({ data });
    return { message: 'Concerns saved successfully' };
  }

  async getSaved(patientId: number) {
    return (prisma as any).patient_concerns.findMany({
      where: { patient_id: patientId },
    });
  }
}
