import { PrismaClient } from '@prisma/client';
import { TokenService } from './token.service';
import { SendGridService } from '../../shared/services/sendgrid.service';
import { AppError } from '../../shared/utils/appError';
import { generateOtp } from '../../shared/utils/otp.util';
import { comparePassword } from '../../shared/utils/hash.util';

export class AuthService {
  constructor(
    private prisma: PrismaClient,
    private tokenService: TokenService,
    private sendgridService: SendGridService
  ) {}

  async adminLogin(email: string, password: string) {
    const user = await this.prisma.user.findFirst({
      where: { email, OR: [{ is_admin: 1 }, { is_sub_admin: 1 }] },
    });

    if (!user || !(await comparePassword(password, user.password))) {
      throw new AppError(401, 'Invalid credentials');
    }

    const accessToken = this.tokenService.generateAccessToken(user.id, 'admin');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, user.id, 'admin');

    return { accessToken, refreshToken };
  }

  async requestOtp(email: string) {
    let customer = await this.prisma.customer.findFirst({ where: { email } });

    if (!customer) {
      customer = await this.prisma.customer.create({ data: { email } });
    }

    const otp = generateOtp();
    const otpExpiresAt = new Date(Date.now() + 5 * 60 * 1000); // 5 minutes

    await this.prisma.customer.update({
      where: { id: customer.id },
      data: { otp, otp_expires_at: otpExpiresAt, otp_attempts: 0 },
    });

    await this.sendgridService.sendOtpEmail(email, otp);

    return { message: 'OTP sent to your email' };
  }

  async verifyOtp(email: string, otp: string) {
    const customer = await this.prisma.customer.findFirst({ where: { email } });

    if (!customer) {
      throw new AppError(401, 'Invalid credentials');
    }

    // Check rate limiting / block
    if (customer.otp_blocked_until && customer.otp_blocked_until > new Date()) {
      throw new AppError(429, 'Too many attempts. Please try again later.');
    }

    // Check expiry
    if (!customer.otp_expires_at || customer.otp_expires_at < new Date()) {
      throw new AppError(401, 'OTP has expired');
    }

    // Check OTP match
    if (customer.otp !== otp) {
      const attempts = (customer.otp_attempts ?? 0) + 1;
      const updateData: { otp_attempts: number; otp_blocked_until?: Date } = { otp_attempts: attempts };

      if (attempts >= 5) {
        updateData.otp_blocked_until = new Date(Date.now() + 10 * 60 * 1000); // 10 min block
      }

      await this.prisma.customer.update({ where: { id: customer.id }, data: updateData });
      throw new AppError(401, 'Invalid OTP');
    }

    // Success — clear OTP fields
    await this.prisma.customer.update({
      where: { id: customer.id },
      data: { otp: null, otp_expires_at: null, otp_attempts: 0, otp_blocked_until: null },
    });

    const accessToken = this.tokenService.generateAccessToken(customer.id, 'customer');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, customer.id, 'customer');

    return { accessToken, refreshToken };
  }

  async refreshTokens(refreshToken: string) {
    const tokenData = await this.tokenService.validateRefreshToken(refreshToken);

    if (!tokenData) {
      throw new AppError(401, 'Invalid or expired refresh token');
    }

    const { userId, userType } = tokenData;
    const role = userType as 'admin' | 'customer';

    // Rotate refresh token (invalidate old, generate new)
    const newRefreshToken = await this.tokenService.rotateRefreshToken(refreshToken, userId, userType);

    // Generate new access token
    const accessToken = this.tokenService.generateAccessToken(userId, role);

    return { accessToken, refreshToken: newRefreshToken };
  }
}
