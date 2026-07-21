import { Request, Response, NextFunction } from 'express';
import { errorResponse } from '../shared/utils/response.util';

/**
 * Customer guard — ensures the authenticated user has role === 'customer'.
 * Must be used AFTER authMiddleware.
 */
export function customerGuard(req: Request, res: Response, next: NextFunction) {
  if ((req as any).user?.role !== 'customer') {
    return res.status(403).json(errorResponse(403, 'Forbidden: Customer access only'));
  }
  next();
}
