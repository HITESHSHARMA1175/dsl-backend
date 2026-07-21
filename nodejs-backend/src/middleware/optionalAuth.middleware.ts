import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';

interface JwtPayload {
  sub: number;
  role: 'admin' | 'customer';
  iat: number;
  exp: number;
}

/**
 * Optional auth middleware — reads JWT if present and valid, but does NOT
 * reject requests without a token. Use this on routes that support both
 * guest and authenticated users (e.g. cart checkout).
 */
export function optionalAuthMiddleware(req: Request, _res: Response, next: NextFunction) {
  const authHeader = req.headers.authorization;
  if (authHeader?.startsWith('Bearer ')) {
    const token = authHeader.slice(7);
    try {
      const payload = jwt.verify(token, env.JWT_ACCESS_SECRET) as unknown as JwtPayload;
      req.user = { id: payload.sub, role: payload.role };
    } catch {
      // Token invalid or expired — treat as guest, do not block
    }
  }
  next();
}
