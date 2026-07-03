import { prisma } from '../../config/database';

// teams.<day> / <day>_start / <day>_end have no DB default, so every create
// must populate them even when the client doesn't send a schedule.
const DEFAULT_SCHEDULE = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'].reduce(
  (acc, day) => {
    acc[day] = false;
    acc[`${day}_start`] = new Date('1970-01-01T00:00:00');
    acc[`${day}_end`] = new Date('1970-01-01T00:00:00');
    return acc;
  },
  {} as Record<string, boolean | Date>
);

export class TeamService {
  async list() {
    return (prisma as any).teams.findMany();
  }

  async create(data: { name: string; designation?: string; image?: string; description?: string }) {
    return (prisma as any).teams.create({
      data: {
        ...DEFAULT_SCHEDULE,
        team_name: data.name,
        designation: data.designation,
        profile: data.image,
        description: data.description,
      },
    });
  }

  async update(id: number, data: { name?: string; designation?: string; image?: string; description?: string }) {
    return (prisma as any).teams.update({
      where: { id },
      data: {
        team_name: data.name,
        designation: data.designation,
        profile: data.image,
        description: data.description,
      },
    });
  }

  async delete(id: number) {
    await (prisma as any).teams.delete({ where: { id } });
    return { message: 'Team member deleted successfully' };
  }

  async toggleStatus(id: number) {
    const member = await (prisma as any).teams.findUnique({ where: { id } });
    if (!member) throw new Error('Team member not found');
    const newStatus = member.status === 1 ? 0 : 1;
    return (prisma as any).teams.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
