import { Request, Response, NextFunction } from 'express';
import { TreatmentService } from './treatment.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const treatmentService = new TreatmentService(prisma);

export async function listTreatments(req: Request, res: Response, next: NextFunction) {
  try {
    const treatmentType = req.query.treatment_type
      ? Number(req.query.treatment_type)
      : undefined;
    const treatments = await treatmentService.list(treatmentType);
    return res.status(200).json(successResponse(200, 'Success', treatments));
  } catch (error) {
    next(error);
  }
}

export async function createTreatment(req: Request, res: Response, next: NextFunction) {
  try {
    const treatment = await treatmentService.create(req.body);
    return res.status(201).json(successResponse(201, 'Treatment created', treatment));
  } catch (error) {
    next(error);
  }
}

export async function updateTreatment(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const treatment = await treatmentService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Treatment updated', treatment));
  } catch (error) {
    next(error);
  }
}

export async function deleteTreatment(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    await treatmentService.delete(id);
    return res.status(200).json(successResponse(200, 'Treatment deleted', null));
  } catch (error) {
    next(error);
  }
}
