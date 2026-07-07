import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';
import { errorResponse } from '../shared/utils/response.util';

interface JwtPayload {
  sub: number;
  role: 'admin' | 'customer';
  iat: number;
  exp: number;
}

export function authMiddleware(req: Request, res: Response, next: NextFunction) {
  const authHeader = req.headers.authorization;
  if (!authHeader?.startsWith('Bearer ')) {
    return res.status(401).json(errorResponse(401, 'Unauthorized: No token provided'));
  }

  const token = authHeader.slice(7);
  try {
    const payload = jwt.verify(token, env.JWT_ACCESS_SECRET) as unknown as JwtPayload;
    req.user = { id: payload.sub, role: payload.role };
    next();
  } catch (err: any) {
    if (err.name === 'TokenExpiredError') {
      return res.status(401).json(errorResponse(401, 'Token has expired'));
    }
    return res.status(401).json(errorResponse(401, 'Invalid token'));
  }
}
