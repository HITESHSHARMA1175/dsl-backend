import { Request, Response, NextFunction } from 'express';
import { AuthService } from './auth.service';
import { TokenService } from './token.service';
import { SendGridService } from '../../shared/services/sendgrid.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const tokenService = new TokenService(prisma);
const sendgridService = new SendGridService();
const authService = new AuthService(tokenService, sendgridService);

export async function adminLogin(req: Request, res: Response, next: NextFunction) {
  try {
    const { email, password } = req.body;
    const result = await authService.adminLogin(email, password);
    return res.status(200).json(successResponse(200, 'Login successful', result));
  } catch (error) {
    next(error);
  }
}

export async function customerLogin(req: Request, res: Response, next: NextFunction) {
  try {
    const { email, password } = req.body;
    const result = await authService.customerLogin(email, password);
    return res.status(200).json(successResponse(200, 'Login successful', result));
  } catch (error) {
    next(error);
  }
}

export async function customerRegister(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await authService.customerRegister(req.body);
    return res.status(201).json(successResponse(201, 'Registration successful', result));
  } catch (error) {
    next(error);
  }
}

export async function forgotPassword(req: Request, res: Response, next: NextFunction) {
  try {
    const { email } = req.body;
    const result = await authService.forgotPassword(email);
    return res.status(200).json(successResponse(200, result.message, { resetCode: result.resetCode, userType: result.userType }));
  } catch (error) {
    next(error);
  }
}

export async function resetPassword(req: Request, res: Response, next: NextFunction) {
  try {
    const { token, password } = req.body;
    const result = await authService.resetPassword(token, password);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function changePassword(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const { current_password, new_password } = req.body;
    const result = await authService.changePassword(customerId, current_password, new_password);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function logout(req: Request, res: Response, next: NextFunction) {
  try {
    const { refreshToken } = req.body;
    await authService.logout(refreshToken);
    return res.status(200).json(successResponse(200, 'Logout successful', null));
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

export async function customerRefresh(req: Request, res: Response, next: NextFunction) {
  try {
    const { refreshToken } = req.body;
    const tokens = await authService.refreshTokens(refreshToken);
    return res.status(200).json(successResponse(200, 'Token refreshed', tokens));
  } catch (error) {
    next(error);
  }
}
