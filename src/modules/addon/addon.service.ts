import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

export class AddonService {
  constructor(private prisma: PrismaClient) {}

  async list(parentId?: number, page = 1, perPage = 10) {
    const where: { parent_id?: number } = {};
    if (parentId !== undefined) {
      where.parent_id = parentId;
    }

    const [items, total] = await Promise.all([
      this.prisma.addon.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        select: {
          id: true,
          parent_id: true,
          addon_name: true,
          description: true,
          price: true,
          discounted_price: true,
          number_of_members_required: true,
          duration: true,
          profile: true,
        },
      }),
      this.prisma.addon.count({ where }),
    ]);

    return { items, total };
  }

  async create(data: {
    addon_name: string;
    parent_id?: number;
    description?: string;
    price?: number;
    discounted_price?: number;
    number_of_members_required?: number;
    duration?: number;
    profile?: string;
    status?: number;
  }) {
    const addon = await this.prisma.addon.create({ data });
    return addon;
  }

  async update(
    id: number,
    data: {
      addon_name?: string;
      parent_id?: number;
      description?: string;
      price?: number;
      discounted_price?: number;
      number_of_members_required?: number;
      duration?: number;
      profile?: string;
      status?: number;
    }
  ) {
    const existing = await this.prisma.addon.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Addon not found');
    }

    const addon = await this.prisma.addon.update({ where: { id }, data });
    return addon;
  }

  async delete(id: number) {
    const existing = await this.prisma.addon.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Addon not found');
    }

    await this.prisma.addon.delete({ where: { id } });
    return { message: 'Addon deleted successfully' };
  }

  async toggleStatus(id: number) {
    const existing = await this.prisma.addon.findUnique({ where: { id } });
    if (!existing) {
      throw new AppError(404, 'Addon not found');
    }

    const newStatus = existing.status === 1 ? 0 : 1;
    const addon = await this.prisma.addon.update({
      where: { id },
      data: { status: newStatus },
    });

    return addon;
  }
}
