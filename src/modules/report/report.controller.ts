import { Request, Response, NextFunction } from 'express';
import { ReportService } from './report.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new ReportService(prisma);

export async function getCustomers(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getCustomers(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getEmiList(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getEmiList(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getActiveEmi(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getActiveEmi(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getPendingEmi(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getPendingEmi(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getBounceEmi(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getBounceEmi(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}
