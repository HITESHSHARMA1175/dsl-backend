import { Request, Response, NextFunction } from 'express';
import { SlotService } from './slot.service';
import { prisma } from '../../config/database';
import { getAvailableSlotsSchema } from './slot.schema';
import { successResponse, errorResponse } from '../../shared/utils/response.util';

const slotService = new SlotService(prisma);

export async function getAvailableSlots(req: Request, res: Response, next: NextFunction) {
  try {
    const result = getAvailableSlotsSchema.safeParse(req.query);
    if (!result.success) {
      const firstError = result.error.errors[0]?.message ?? 'Validation error';
      return res.status(400).json(errorResponse(400, firstError));
    }

    const { professional_id, date, total_service_duration } = result.data;

    const slots = await slotService.getAvailableSlots(
      professional_id,
      date,
      total_service_duration
    );

    return res.status(200).json(successResponse(200, 'Available slots retrieved successfully', slots));
  } catch (error) {
    next(error);
  }
}
