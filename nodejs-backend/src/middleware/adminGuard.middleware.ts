import { Request, Response, NextFunction } from 'express';
import { errorResponse } from '../shared/utils/response.util';

export function adminGuard(req: Request, res: Response, next: NextFunction) {
  if (req.user?.role !== 'admin') {
    return res.status(403).json(errorResponse(403, 'Forbidden: Admin access required'));
  }
  next();
}
