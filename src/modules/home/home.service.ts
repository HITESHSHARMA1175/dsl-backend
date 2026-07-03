import { prisma } from '../../config/database';

export class HomeService {
  async getHomePage() {
    const [
      categories,
      services,
      treatments,
      professionals,
      teams,
    ] = await Promise.all([
      (prisma as any).propertyCategory.findMany({
        where: { parent_id: 0, status: 1 },
        take: 10,
      }),
      (prisma as any).property.findMany({
        where: { status: 1 },
        take: 10,
        orderBy: { id: 'desc' },
      }),
      (prisma as any).treatment.findMany({
        where: { status: 1 },
        take: 10,
        orderBy: { id: 'desc' },
      }),
      (prisma as any).professional.findMany({
        where: { status: 1 },
        take: 10,
      }),
      (prisma as any).teams.findMany({
        where: { status: 1 },
        take: 10,
      }),
    ]);

    return {
      categories,
      services,
      treatments,
      professionals,
      teams,
    };
  }
}
