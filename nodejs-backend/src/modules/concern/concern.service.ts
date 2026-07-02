import { prisma } from '../../config/database';

export class ConcernService {
  async getTypes() {
    return (prisma as any).concern.findMany();
  }

  async list() {
    return (prisma as any).concern.findMany();
  }

  async save(patientId: number, concernIds: number[]) {
    // Delete existing concerns for this patient
    await (prisma as any).patient_concern.deleteMany({
      where: { patient_id: patientId },
    });

    // Insert new concerns
    const data = concernIds.map((concernId: number) => ({
      patient_id: patientId,
      concern_id: concernId,
    }));

    await (prisma as any).patient_concern.createMany({ data });
    return { message: 'Concerns saved successfully' };
  }

  async getSaved(patientId: number) {
    return (prisma as any).patient_concern.findMany({
      where: { patient_id: patientId },
    });
  }
}
