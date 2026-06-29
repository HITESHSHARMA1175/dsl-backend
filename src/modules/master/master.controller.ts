import { Request, Response, NextFunction } from 'express';
import { MasterService } from './master.service';
import { prisma } from '../../config/database';
import { successResponse, errorResponse } from '../../shared/utils/response.util';
import { masterValuesQuerySchema } from './master.schema';

const masterService = new MasterService(prisma);

export async function getValues(req: Request, res: Response, next: NextFunction) {
  try {
    const parsed = masterValuesQuerySchema.safeParse(req.query);
    if (!parsed.success) {
      const firstError = parsed.error.errors[0]?.message ?? 'Validation error';
      return res.status(400).json(errorResponse(400, firstError));
    }
    const { MasterHead } = parsed.data;
    const values = await masterService.getValues(MasterHead);
    return res.status(200).json(successResponse(200, 'Success', values));
  } catch (error) {
    next(error);
  }
}
