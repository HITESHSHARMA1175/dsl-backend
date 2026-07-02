import { AppError } from '../../shared/utils/appError';
import { hashPassword } from '../../shared/utils/hash.util';

/**
 * Sub-admin management.
 * Operates on the `users` table filtered by the `is_sub_admin` enum (Yes/No).
 */
export class SubadminService {
  constructor(private prisma: any) {}

  async list(page = 1, perPage = 10, search?: string) {
    const where: any = { is_sub_admin: 'Yes' };
    if (search) {
      where.OR = [
        { first_name: { contains: search } },
        { last_name: { contains: search } },
        { email: { contains: search } },
        { mobile_no: { contains: search } },
      ];
    }

    const [items, total] = await Promise.all([
      this.prisma.user.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.user.count({ where }),
    ]);

    return { items, total };
  }

  async getById(id: number) {
    const user = await this.prisma.user.findUnique({ where: { id } });
    if (!user || user.is_sub_admin !== 'Yes') {
      throw new AppError(404, 'Sub-admin not found');
    }
    return user;
  }

  async create(data: any) {
    const existing = await this.prisma.user.findUnique({ where: { email: data.email } });
    if (existing) {
      throw new AppError(409, 'A user with this email already exists');
    }

    const hashed = await hashPassword(data.password);

    return this.prisma.user.create({
      data: {
        first_name: data.first_name,
        last_name: data.last_name || null,
        email: data.email,
        mobile_no: data.mobile_no || null,
        password: hashed,
        password_copy: data.password,
        menu_permission: data.menu_permission || null,
        designation: data.designation || null,
        is_admin: 0,
        is_sub_admin: 'Yes',
        is_seller: 'No',
        is_kyc: 'No',
        status: 1,
      },
    });
  }

  async update(id: number, data: any) {
    const existing = await this.prisma.user.findUnique({ where: { id } });
    if (!existing || existing.is_sub_admin !== 'Yes') {
      throw new AppError(404, 'Sub-admin not found');
    }

    const payload: any = {
      first_name: data.first_name ?? existing.first_name,
      last_name: data.last_name ?? existing.last_name,
      mobile_no: data.mobile_no ?? existing.mobile_no,
      menu_permission: data.menu_permission ?? existing.menu_permission,
      designation: data.designation ?? existing.designation,
    };

    if (data.password) {
      payload.password = await hashPassword(data.password);
      payload.password_copy = data.password;
    }

    return this.prisma.user.update({ where: { id }, data: payload });
  }

  async toggleStatus(id: number) {
    const user = await this.prisma.user.findUnique({ where: { id } });
    if (!user || user.is_sub_admin !== 'Yes') {
      throw new AppError(404, 'Sub-admin not found');
    }
    const newStatus = user.status === 1 ? 0 : 1;
    return this.prisma.user.update({ where: { id }, data: { status: newStatus } });
  }
}
