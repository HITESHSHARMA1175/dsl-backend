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

export async function checkCustomer(req: Request, res: Response, next: NextFunction) {
  try {
    const { identifier } = req.body;
    if (!identifier) {
      return res.status(400).json({ success: false, message: 'Email or mobile is required' });
    }

    const cleanIdentifier = identifier.trim();

    // 1. First check customer table
    let customer = await (prisma as any).customer.findFirst({
      where: {
        OR: [
          { email: cleanIdentifier },
          { mobile: cleanIdentifier }
        ]
      }
    });

    let exists = !!customer;
    let isRegistered = !!(customer && customer.password);
    let email = customer?.email || (cleanIdentifier.includes('@') ? cleanIdentifier : '');
    let mobile = customer?.mobile || (!cleanIdentifier.includes('@') ? cleanIdentifier : '');
    let firstName = customer?.first_name || '';
    let lastName = customer?.last_name || '';

    // 2. If not found in customer table, search order table for guest checkout details
    if (!customer) {
      const order = await (prisma as any).order.findFirst({
        where: {
          OR: [
            { billing_email: cleanIdentifier },
            { billing_phone: cleanIdentifier }
          ]
        },
        orderBy: { id: 'desc' }
      });

      if (order) {
        exists = true;
        isRegistered = false;
        email = order.billing_email || email;
        mobile = order.billing_phone || mobile;
        firstName = order.billing_first_name || '';
        lastName = order.billing_last_name || '';
      }
    }

    return res.status(200).json(successResponse(200, 'Success', {
      exists,
      isRegistered,
      email,
      mobile,
      firstName,
      lastName
    }));
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
    await authService.logout(refreshToken, req.user!.id, req.user!.role);
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
