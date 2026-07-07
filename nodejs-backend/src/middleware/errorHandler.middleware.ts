import { Request, Response, NextFunction } from 'express';
import { env } from '../config/env';

export function errorHandler(err: Error, req: Request, res: Response, next: NextFunction) {
  const status = (err as any).statusCode ?? 500;
  console.error(`[${req.method} ${req.originalUrl}]`, err);
  const message = env.NODE_ENV === 'production'
    ? 'Internal server error'
    : err.message;

  res.status(status).json({
    error: true,
    status,
    success: false,
    message,
  });
}
