import { Request, Response, NextFunction } from 'express';
import { TreatmentsService } from './treatments.service';
import { prisma } from '../../config/database';

const treatmentsService = new TreatmentsService(prisma);

export async function getTreatmentsNavbar(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await treatmentsService.getNavbar();
    return res.status(200).json({ success: true, data });
  } catch (error) {
    next(error);
  }
}

export async function getTreatmentBySlug(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await treatmentsService.getBySlug(String(req.params.slug));
    return res.status(200).json({ success: true, data });
  } catch (error) {
    next(error);
  }
}
