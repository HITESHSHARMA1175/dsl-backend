import { Request, Response, NextFunction } from 'express';
import { ZodSchema } from 'zod';
import { errorResponse } from '../shared/utils/response.util';

export function validate(schema: ZodSchema) {
  return (req: Request, res: Response, next: NextFunction) => {
    const result = schema.safeParse(req.body);
    if (!result.success) {
      const firstError = result.error.errors[0]?.message ?? 'Validation error';
      return res.status(400).json(errorResponse(400, firstError));
    }
    req.body = result.data;
    next();
  };
}
