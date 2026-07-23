import { Request, Response, NextFunction } from 'express';
import { env } from '../config/env';

export function errorHandler(err: Error, req: Request, res: Response, next: NextFunction) {
  const status = (err as any).statusCode ?? 500;
  console.error(`[${req.method} ${req.originalUrl}]`, err);

  // Return specific operational error message for 4xx client errors (e.g., 401 Invalid credentials)
  const message = status < 500 || (err as any).isOperational
    ? err.message
    : (env.NODE_ENV === 'production' ? 'Internal server error' : err.message);

  res.status(status).json({
    error: true,
    status,
    success: false,
    message,
  });
}
