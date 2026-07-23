import crypto from 'crypto';
import { TokenService } from './token.service';
import { SendGridService } from '../../shared/services/sendgrid.service';
import { AppError } from '../../shared/utils/appError';
import { comparePassword, hashPassword } from '../../shared/utils/hash.util';
import { prisma } from '../../config/database';

export class AuthService {
  constructor(
    private tokenService: TokenService,
    private sendgridService: SendGridService
  ) {}

  // ==================== ADMIN LOGIN ====================
  async adminLogin(email: string, password: string) {
    const user = await (prisma as any).user.findFirst({
      where: { email },
    });

    if (!user) {
      throw new AppError(401, 'Invalid credentials');
    }

    // Check if user is admin or sub-admin (enum values are 'Yes'/'No' after Prisma mapping, or check raw value)
    const isAdmin = user.is_admin === 1 || user.is_admin === '1' || user.is_admin === true;
    const isSubAdmin = user.is_sub_admin === 'Yes' || user.is_sub_admin === 1 || user.is_sub_admin === '1' || user.is_sub_admin === true;

    if (!isAdmin && !isSubAdmin) {
      throw new AppError(401, 'Invalid credentials');
    }

    // Try bcrypt compare first, fallback to password_copy (plaintext) for legacy accounts
    let passwordValid = false;
    try {
      passwordValid = await comparePassword(password, user.password);
    } catch (e) {
      passwordValid = false;
    }

    // Fallback: check password_copy field (legacy plaintext passwords)
    if (!passwordValid && user.password_copy) {
      passwordValid = (password === user.password_copy);
    }

    if (!passwordValid) {
      throw new AppError(401, 'Invalid credentials');
    }

    const accessToken = this.tokenService.generateAccessToken(Number(user.id), 'admin');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, Number(user.id), 'admin');

    return {
      accessToken,
      refreshToken,
      user: { id: Number(user.id), email: user.email, first_name: user.first_name, last_name: user.last_name },
    };
  }

  // ==================== LOGOUT ====================
  async logout(refreshToken: string, userId: number, userType: string): Promise<void> {
    await this.tokenService.revokeRefreshToken(refreshToken, userId, userType);
  }

  // ==================== CUSTOMER LOGIN (Email + Password) ====================
  async customerLogin(email: string, password: string) {
    const customer = await (prisma as any).customer.findFirst({
      where: { email },
    });

    if (!customer) {
      throw new AppError(401, 'Invalid email or password');
    }

    if (!customer.password) {
      throw new AppError(401, 'No password set. Please register first.');
    }

    let passwordValid = false;
    try {
      passwordValid = await comparePassword(password, customer.password);
    } catch (e) {
      passwordValid = false;
    }

    if (!passwordValid && customer.password_copy) {
      passwordValid = (password === customer.password_copy);
    }

    if (!passwordValid && customer.password) {
      passwordValid = (password === customer.password);
    }

    if (!passwordValid) {
      throw new AppError(401, 'Invalid email or password');
    }

    const accessToken = this.tokenService.generateAccessToken(Number(customer.id), 'customer');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, Number(customer.id), 'customer');

    return {
      accessToken,
      refreshToken,
      customer: {
        id: Number(customer.id),
        email: customer.email,
        first_name: customer.first_name,
        last_name: customer.last_name,
        mobile: customer.mobile,
      },
    };
  }

  // ==================== CUSTOMER REGISTER ====================
  async customerRegister(data: { first_name: string; last_name?: string; email: string; password: string; mobile?: string }) {
    const existing = await (prisma as any).customer.findFirst({
      where: { email: data.email },
    });

    if (existing && existing.password) {
      throw new AppError(409, 'Email already registered. Please login.');
    }

    const hashedPassword = await hashPassword(data.password);

    let customer;
    if (existing) {
      // Existing record without password — set password
      customer = await (prisma as any).customer.update({
        where: { id: existing.id },
        data: {
          first_name: data.first_name,
          last_name: data.last_name || null,
          password: hashedPassword,
          mobile: data.mobile || existing.mobile,
        },
      });
    } else {
      customer = await (prisma as any).customer.create({
        data: {
          first_name: data.first_name,
          last_name: data.last_name || null,
          email: data.email,
          password: hashedPassword,
          mobile: data.mobile || null,
        },
      });
    }

    const accessToken = this.tokenService.generateAccessToken(Number(customer.id), 'customer');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, Number(customer.id), 'customer');

    try {
      await this.sendgridService.sendWelcomeEmail(data.email, data.first_name);
    } catch (e) { /* don't fail registration */ }

    return {
      accessToken,
      refreshToken,
      customer: {
        id: Number(customer.id),
        email: customer.email,
        first_name: customer.first_name,
        last_name: customer.last_name,
        mobile: customer.mobile,
      },
    };
  }

  // ==================== FORGOT PASSWORD ====================
  // Sends a 6-digit reset code to email, stores it. Works for both customers AND admin users.
  async forgotPassword(email: string) {
    // First check customers table
    const customer = await (prisma as any).customer.findFirst({ where: { email } });

    if (!customer) {
      // Check users table (admin/staff)
      const user = await (prisma as any).user.findFirst({ where: { email } });
      if (!user) {
        return { message: 'If this email is registered, you will receive a password reset code.', resetCode: null };
      }
      // Admin user found — store reset code in remember_token
      const resetCode = crypto.randomInt(100000, 999999).toString();
      await (prisma as any).user.update({
        where: { id: user.id },
        data: { remember_token: resetCode },
      });
      try { await this.sendgridService.sendOtpEmail(email, resetCode); } catch (e) { console.warn('Email failed:', (e as any).message); }
      return { message: 'If this email is registered, you will receive a password reset code.', resetCode, userType: 'admin' };
    }

    // Customer found
    const resetCode = crypto.randomInt(100000, 999999).toString();
    await (prisma as any).customer.update({
      where: { id: customer.id },
      data: { otp: parseInt(resetCode) },
    });
    try { await this.sendgridService.sendOtpEmail(email, resetCode); } catch (e) { console.warn('Email failed:', (e as any).message); }
    return { message: 'If this email is registered, you will receive a password reset code.', resetCode, userType: 'customer' };
  }

  // ==================== RESET PASSWORD (using code from email) ====================
  async resetPassword(token: string, newPassword: string) {
    const resetCode = parseInt(token);
    if (isNaN(resetCode)) {
      throw new AppError(400, 'Invalid reset code');
    }

    // Check customers table first (otp field)
    const customer = await (prisma as any).customer.findFirst({
      where: { otp: resetCode },
    });

    if (customer) {
      const hashedPassword = await hashPassword(newPassword);
      await (prisma as any).customer.update({
        where: { id: customer.id },
        data: { password: hashedPassword, otp: 0 },
      });
      return { message: 'Password reset successfully. You can now login with your new password.' };
    }

    // Check users table (remember_token field)
    const user = await (prisma as any).user.findFirst({
      where: { remember_token: token },
    });

    if (user) {
      const hashedPassword = await hashPassword(newPassword);
      await (prisma as any).user.update({
        where: { id: user.id },
        data: { password: hashedPassword, password_copy: newPassword, remember_token: null },
      });
      return { message: 'Password reset successfully. You can now login with your new password.' };
    }

    throw new AppError(400, 'Invalid or expired reset code');
  }

  // ==================== CHANGE PASSWORD (authenticated) ====================
  async changePassword(customerId: number, currentPassword: string, newPassword: string) {
    const customer = await (prisma as any).customer.findFirst({
      where: { id: customerId },
    });

    if (!customer || !customer.password) {
      throw new AppError(400, 'No password set for this account');
    }

    if (!(await comparePassword(currentPassword, customer.password))) {
      throw new AppError(401, 'Current password is incorrect');
    }

    const hashedPassword = await hashPassword(newPassword);

    await (prisma as any).customer.update({
      where: { id: customer.id },
      data: { password: hashedPassword },
    });

    return { message: 'Password changed successfully' };
  }

  // ==================== REFRESH TOKENS ====================
  async refreshTokens(refreshToken: string) {
    const tokenData = await this.tokenService.validateRefreshToken(refreshToken);

    if (!tokenData) {
      throw new AppError(401, 'Invalid or expired refresh token');
    }

    const { userId, userType } = tokenData;
    const role = userType as 'admin' | 'customer';

    const newRefreshToken = await this.tokenService.rotateRefreshToken(refreshToken, userId, userType);
    const accessToken = this.tokenService.generateAccessToken(userId, role);

    return { accessToken, refreshToken: newRefreshToken };
  }
}
