import { Request, Response, NextFunction } from 'express';
import { ConcernService } from './concern.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const concernService = new ConcernService();

export async function getTypes(req: Request, res: Response, next: NextFunction) {
  try {
    const types = await concernService.getTypes();
    return res.status(200).json(successResponse(200, 'Success', types));
  } catch (error) {
    next(error);
  }
}

export async function listConcerns(req: Request, res: Response, next: NextFunction) {
  try {
    const concerns = await concernService.list();
    return res.status(200).json(successResponse(200, 'Success', concerns));
  } catch (error) {
    next(error);
  }
}

export async function saveConcerns(req: Request, res: Response, next: NextFunction) {
  try {
    const { patientId, concernIds } = req.body;
    const result = await concernService.save(patientId, concernIds);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function getSavedConcerns(req: Request, res: Response, next: NextFunction) {
  try {
    const patientId = parseIdParam(req.params.patientId);
    const concerns = await concernService.getSaved(patientId);
    return res.status(200).json(successResponse(200, 'Success', concerns));
  } catch (error) {
    next(error);
  }
}
