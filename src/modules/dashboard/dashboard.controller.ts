import { Request, Response, NextFunction } from 'express';
import { DashboardService } from './dashboard.service';
import { successResponse } from '../../shared/utils/response.util';

const dashboardService = new DashboardService();

export async function getDashboardStats(req: Request, res: Response, next: NextFunction) {
  try {
    const stats = await dashboardService.getStats();
    return res.status(200).json(successResponse(200, 'Success', stats));
  } catch (error) {
    next(error);
  }
}
