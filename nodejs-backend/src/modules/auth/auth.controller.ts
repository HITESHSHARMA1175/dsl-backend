import { Request, Response, NextFunction } from 'express';
import { AuthService } from './auth.service';
import { TokenService } from './token.service';
import { SendGridService } from '../../shared/services/sendgrid.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const tokenService = new TokenService(prisma);
const sendgridService = new SendGridService();
const authService = new AuthService(prisma, tokenService, sendgridService);

export async function adminLogin(req: Request, res: Response, next: NextFunction) {
  try {
    const { email, password } = req.body;
    const tokens = await authService.adminLogin(email, password);
    return res.status(200).json(successResponse(200, 'Login successful', tokens));
  } catch (error) {
    next(error);
  }
}

export async function adminRefresh(req: Request, res: Response, next: NextFunction) {
  try {
    const { refreshToken } = req.body;
    const tokens = await authService.refreshTokens(refreshToken);
    return res.status(200).json(successResponse(200, 'Token refreshed', tokens));
  } catch (error) {
    next(error);
  }
}

export async function requestOtp(req: Request, res: Response, next: NextFunction) {
  try {
    const { email } = req.body;
    const result = await authService.requestOtp(email);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function verifyOtp(req: Request, res: Response, next: NextFunction) {
  try {
    const { email, otp } = req.body;
    const tokens = await authService.verifyOtp(email, otp);
    return res.status(200).json(successResponse(200, 'OTP verified', tokens));
  } catch (error) {
    next(error);
  }
}

export async function customerRefresh(req: Request, res: Response, next: NextFunction) {
  try {
    const { refreshToken } = req.body;
    const tokens = await authService.refreshTokens(refreshToken);
    return res.status(200).json(successResponse(200, 'Token refreshed', tokens));
  } catch (error) {
    next(error);
  }
}
