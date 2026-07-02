import { AppError } from '../../shared/utils/appError';
import { hashPassword } from '../../shared/utils/hash.util';

/**
 * Seller management with KYC approval workflow.
 * Operates on the `users` table filtered by the `is_seller` enum (Yes/No).
 */
export class SellerService {
  constructor(private prisma: any) {}

  async list(page = 1, perPage = 10, filters?: { search?: string; kyc?: string }) {
    const where: any = { is_seller: 'Yes' };
    if (filters?.kyc) {
      where.is_kyc = filters.kyc; // 'Yes' | 'No'
    }
    if (filters?.search) {
      where.OR = [
        { first_name: { contains: filters.search } },
        { last_name: { contains: filters.search } },
        { email: { contains: filters.search } },
        { mobile_no: { contains: filters.search } },
        { shop_name: { contains: filters.search } },
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
    if (!user || user.is_seller !== 'Yes') {
      throw new AppError(404, 'Seller not found');
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
        shop_name: data.shop_name || null,
        shop_gst: data.shop_gst || null,
        shop_pan: data.shop_pan || null,
        address: data.address || null,
        is_admin: 0,
        is_sub_admin: 'No',
        is_seller: 'Yes',
        is_kyc: 'No',
        status: 1,
      },
    });
  }

  async update(id: number, data: any) {
    const existing = await this.prisma.user.findUnique({ where: { id } });
    if (!existing || existing.is_seller !== 'Yes') {
      throw new AppError(404, 'Seller not found');
    }

    const payload: any = {
      first_name: data.first_name ?? existing.first_name,
      last_name: data.last_name ?? existing.last_name,
      mobile_no: data.mobile_no ?? existing.mobile_no,
      shop_name: data.shop_name ?? existing.shop_name,
      shop_gst: data.shop_gst ?? existing.shop_gst,
      shop_pan: data.shop_pan ?? existing.shop_pan,
      address: data.address ?? existing.address,
    };

    if (data.password) {
      payload.password = await hashPassword(data.password);
      payload.password_copy = data.password;
    }

    return this.prisma.user.update({ where: { id }, data: payload });
  }

  async toggleStatus(id: number) {
    const user = await this.prisma.user.findUnique({ where: { id } });
    if (!user || user.is_seller !== 'Yes') {
      throw new AppError(404, 'Seller not found');
    }
    const newStatus = user.status === 1 ? 0 : 1;
    return this.prisma.user.update({ where: { id }, data: { status: newStatus } });
  }

  async approveKyc(id: number) {
    const user = await this.prisma.user.findUnique({ where: { id } });
    if (!user || user.is_seller !== 'Yes') {
      throw new AppError(404, 'Seller not found');
    }
    const newKyc = user.is_kyc === 'Yes' ? 'No' : 'Yes';
    return this.prisma.user.update({ where: { id }, data: { is_kyc: newKyc } });
  }

  async kycList(page = 1, perPage = 10) {
    const where: any = { is_seller: 'Yes', is_kyc: 'No' };
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
}
