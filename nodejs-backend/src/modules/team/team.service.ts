import { prisma } from '../../config/database';

export class TeamService {
  async list() {
    return (prisma as any).team.findMany();
  }

  async create(data: any) {
    return (prisma as any).team.create({ data });
  }

  async update(id: number, data: any) {
    return (prisma as any).team.update({
      where: { id },
      data,
    });
  }

  async delete(id: number) {
    await (prisma as any).team.delete({ where: { id } });
    return { message: 'Team member deleted successfully' };
  }

  async toggleStatus(id: number) {
    const member = await (prisma as any).team.findUnique({ where: { id } });
    if (!member) throw new Error('Team member not found');
    const newStatus = member.status === 1 ? 0 : 1;
    return (prisma as any).team.update({
      where: { id },
      data: { status: newStatus },
    });
  }
}
