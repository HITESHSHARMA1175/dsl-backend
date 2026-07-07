import { Request, Response, NextFunction } from 'express';
import { AgentService } from './agent.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const agentService = new AgentService(prisma);

export async function register(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.register(req.body);
    return res.status(201).json(successResponse(201, 'Registered successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function login(req: Request, res: Response, next: NextFunction) {
  try {
    const { email, password, device_token } = req.body;
    const data = await agentService.login(email, password, device_token);
    return res.status(200).json(successResponse(200, 'Login successful', data));
  } catch (error) {
    next(error);
  }
}

export async function updateDeviceToken(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await agentService.updateDeviceToken(req.user!.id, req.body.device_token);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function myProfile(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.getProfile(req.user!.id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function updateProfile(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.updateProfile(req.user!.id, req.body);
    return res.status(200).json(successResponse(200, 'Profile updated', data));
  } catch (error) {
    next(error);
  }
}

export async function kycDetails(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.getKyc(req.user!.id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function updateKyc(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.updateKyc(req.user!.id, req.body);
    return res.status(200).json(successResponse(200, 'KYC updated', data));
  } catch (error) {
    next(error);
  }
}

export async function getBusinessName(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.getBusinessName(req.user!.id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function updateBusinessName(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.updateBusinessName(req.user!.id, req.body);
    return res.status(200).json(successResponse(200, 'Business details updated', data));
  } catch (error) {
    next(error);
  }
}

export async function updateAddress(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.updateAddress(req.user!.id, req.body);
    return res.status(200).json(successResponse(200, 'Address updated', data));
  } catch (error) {
    next(error);
  }
}

export async function myPayment(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await agentService.getPayments(req.user!.id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}
