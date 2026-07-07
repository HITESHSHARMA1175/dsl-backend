import jwt from 'jsonwebtoken';
import { env } from '../../config/env';
import { AppError } from '../../shared/utils/appError';
import { comparePassword, hashPassword } from '../../shared/utils/hash.util';

/**
 * Agent / Seller mobile-app module (Laravel Api/User + agent login).
 * Operates on the `users` table. Issues JWTs with the 'agent' role.
 */
export class AgentService {
  constructor(private prisma: any) {}

  private issueToken(userId: number) {
    return jwt.sign({ sub: userId, role: 'agent' }, env.JWT_ACCESS_SECRET, { expiresIn: '7d' });
  }

  async register(data: any) {
    const existing = await this.prisma.user.findUnique({ where: { email: data.email } });
    if (existing) {
      throw new AppError(409, 'A user with this email already exists');
    }
    const hashed = await hashPassword(data.password);
    const user = await this.prisma.user.create({
      data: {
        first_name: data.first_name,
        last_name: data.last_name || null,
        email: data.email,
        mobile_no: data.mobile_no || null,
        password: hashed,
        password_copy: data.password,
        emp_type: 'Seller',
        is_admin: 0,
        is_sub_admin: 'No',
        is_seller: 'Yes',
        is_kyc: 'No',
        status: 1,
      },
    });
    const token = this.issueToken(Number(user.id));
    return { token, user: { id: user.id, email: user.email, first_name: user.first_name } };
  }

  async login(email: string, password: string, deviceToken?: string) {
    const user = await this.prisma.user.findFirst({ where: { email } });
    if (!user) {
      throw new AppError(401, 'Invalid credentials');
    }

    let valid = false;
    try {
      valid = await comparePassword(password, user.password);
    } catch {
      valid = false;
    }
    if (!valid && user.password_copy) {
      valid = password === user.password_copy;
    }
    if (!valid) {
      throw new AppError(401, 'Invalid credentials');
    }

    if (deviceToken) {
      await this.prisma.user.update({ where: { id: user.id }, data: { remember_token: deviceToken } });
    }

    const token = this.issueToken(Number(user.id));
    return {
      token,
      user: { id: user.id, email: user.email, first_name: user.first_name, last_name: user.last_name },
    };
  }

  async updateDeviceToken(userId: number, deviceToken: string) {
    await this.prisma.user.update({ where: { id: userId }, data: { remember_token: deviceToken } });
    return { message: 'Device token updated' };
  }

  async getProfile(userId: number) {
    const user = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!user) {
      throw new AppError(404, 'User not found');
    }
    const { password, password_copy, ...safe } = user;
    return safe;
  }

  async updateProfile(userId: number, data: any) {
    const existing = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!existing) {
      throw new AppError(404, 'User not found');
    }
    return this.prisma.user.update({
      where: { id: userId },
      data: {
        first_name: data.first_name ?? existing.first_name,
        last_name: data.last_name ?? existing.last_name,
        mobile_no: data.mobile_no ?? existing.mobile_no,
        gender: data.gender ?? existing.gender,
        dob: data.dob ? new Date(data.dob) : existing.dob,
        profile: data.profile ?? existing.profile,
      },
    });
  }

  async getKyc(userId: number) {
    const user = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!user) {
      throw new AppError(404, 'User not found');
    }
    return {
      is_kyc: user.is_kyc,
      aadhar_number: user.aadhar_number,
      pan_number: user.pan_number,
      upload_aadhaar: user.upload_aadhaar,
      upload_pan: user.upload_pan,
      account_name: user.account_name,
      account_no: user.account_no,
      bank_name: user.bank_name,
      ifcs: user.ifcs,
      bank_address: user.bank_address,
    };
  }

  async updateKyc(userId: number, data: any) {
    const existing = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!existing) {
      throw new AppError(404, 'User not found');
    }
    return this.prisma.user.update({
      where: { id: userId },
      data: {
        aadhar_number: data.aadhar_number ?? existing.aadhar_number,
        pan_number: data.pan_number ?? existing.pan_number,
        upload_aadhaar: data.upload_aadhaar ?? existing.upload_aadhaar,
        upload_pan: data.upload_pan ?? existing.upload_pan,
        account_name: data.account_name ?? existing.account_name,
        account_no: data.account_no ?? existing.account_no,
        bank_name: data.bank_name ?? existing.bank_name,
        ifcs: data.ifcs ?? existing.ifcs,
        bank_address: data.bank_address ?? existing.bank_address,
      },
    });
  }

  async getBusinessName(userId: number) {
    const user = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!user) {
      throw new AppError(404, 'User not found');
    }
    return {
      business_name: user.business_name,
      business_type: user.business_type,
      business_category: user.business_category,
      business_email: user.business_email,
    };
  }

  async updateBusinessName(userId: number, data: any) {
    const existing = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!existing) {
      throw new AppError(404, 'User not found');
    }
    return this.prisma.user.update({
      where: { id: userId },
      data: {
        business_name: data.business_name ?? existing.business_name,
        business_type: data.business_type ?? existing.business_type,
        business_category: data.business_category ?? existing.business_category,
        business_email: data.business_email ?? existing.business_email,
      },
    });
  }

  async updateAddress(userId: number, data: any) {
    const existing = await this.prisma.user.findUnique({ where: { id: userId } });
    if (!existing) {
      throw new AppError(404, 'User not found');
    }
    return this.prisma.user.update({
      where: { id: userId },
      data: {
        address: data.address ?? existing.address,
        country: data.country ?? existing.country,
        state: data.state ?? existing.state,
        city: data.city ?? existing.city,
        pincode: data.pincode ?? existing.pincode,
      },
    });
  }

  async getPayments(userId: number) {
    return this.prisma.lead_payments.findMany({
      where: { user_id: userId },
      orderBy: { id: 'desc' },
    });
  }
}
