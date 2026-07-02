import { Request, Response, NextFunction } from 'express';
import { ExportService } from './export.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new ExportService(prisma);

export async function exportLeads(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.exportLeads(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function exportData(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.exportData(req.query);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}
