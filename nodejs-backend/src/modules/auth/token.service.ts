import jwt from 'jsonwebtoken';
import crypto from 'crypto';
import { PrismaClient } from '@prisma/client';
import { env } from '../../config/env';

export class TokenService {
  constructor(private prisma: PrismaClient) {}

  generateAccessToken(userId: number, role: 'admin' | 'customer'): string {
    return jwt.sign(
      { sub: userId, role },
      env.JWT_ACCESS_SECRET,
      { expiresIn: '15m' }
    );
  }

  generateRefreshToken(): string {
    return crypto.randomBytes(40).toString('hex');
  }

  async storeRefreshToken(token: string, userId: number, userType: string): Promise<void> {
    const expiresAt = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000); // 7 days
    await this.prisma.refreshToken.create({
      data: { token, user_id: userId, user_type: userType, expires_at: expiresAt },
    });
  }

  async rotateRefreshToken(oldToken: string, userId: number, userType: string): Promise<string> {
    // Invalidate old token
    await this.prisma.refreshToken.updateMany({
      where: { token: oldToken, user_id: userId },
      data: { revoked: true },
    });
    // Generate and store new token
    const newToken = this.generateRefreshToken();
    await this.storeRefreshToken(newToken, userId, userType);
    return newToken;
  }

  async validateRefreshToken(token: string): Promise<{ userId: number; userType: string } | null> {
    const record = await this.prisma.refreshToken.findUnique({ where: { token } });
    if (!record || record.revoked || record.expires_at < new Date()) {
      return null;
    }
    return { userId: record.user_id, userType: record.user_type };
  }
}
