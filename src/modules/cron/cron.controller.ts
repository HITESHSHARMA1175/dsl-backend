import { Request, Response, NextFunction } from 'express';
import { CronService } from './cron.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new CronService(prisma);

export async function createMoveinPayment(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.createMoveinPayment();
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function sendBirthdayEmails(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.sendBirthdayEmails();
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
