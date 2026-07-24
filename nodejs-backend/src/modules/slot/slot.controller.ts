import { Request, Response, NextFunction } from 'express';
import { SlotService } from './slot.service';
import { prisma } from '../../config/database';
import { successResponse, errorResponse } from '../../shared/utils/response.util';

const slotService = new SlotService(prisma);

/** GET /api/v1/slots — List all clinic time slots */
export async function listSlots(req: Request, res: Response, next: NextFunction) {
  try {
    const slots = await slotService.listSlots();
    return res.status(200).json(successResponse(200, 'Time slots retrieved successfully', slots));
  } catch (error) {
    next(error);
  }
}

/** POST /api/v1/slots — Create a new clinic time slot */
export async function createSlot(req: Request, res: Response, next: NextFunction) {
  try {
    const { time } = req.body;
    if (!time || typeof time !== 'string' || !time.trim()) {
      return res.status(400).json(errorResponse(400, 'Time string is required'));
    }

    const slot = await slotService.createSlot(time);
    return res.status(201).json(successResponse(201, 'Slot created successfully', slot));
  } catch (error) {
    next(error);
  }
}

/** PUT /api/v1/slots/:id/toggle — Toggle slot active status */
export async function toggleSlot(req: Request, res: Response, next: NextFunction) {
  try {
    const { id } = req.params;
    if (!id) {
      return res.status(400).json(errorResponse(400, 'Slot ID is required'));
    }

    const updated = await slotService.toggleSlot(id);
    return res.status(200).json(successResponse(200, 'Slot status updated', updated));
  } catch (error) {
    next(error);
  }
}

/** DELETE /api/v1/slots/:id — Delete a slot */
export async function deleteSlot(req: Request, res: Response, next: NextFunction) {
  try {
    const { id } = req.params;
    if (!id) {
      return res.status(400).json(errorResponse(400, 'Slot ID is required'));
    }

    const result = await slotService.deleteSlot(id);
    return res.status(200).json(successResponse(200, result.message));
  } catch (error) {
    next(error);
  }
}

/** PUT /api/v1/slots — Bulk update/replace slots */
export async function bulkUpdateSlots(req: Request, res: Response, next: NextFunction) {
  try {
    const { slots } = req.body;
    if (!Array.isArray(slots)) {
      return res.status(400).json(errorResponse(400, 'Slots array is required'));
    }

    const result = await slotService.bulkUpdateSlots(slots);
    return res.status(200).json(successResponse(200, 'Slots updated successfully', result));
  } catch (error) {
    next(error);
  }
}
