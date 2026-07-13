import { Request, Response, NextFunction } from 'express';
import { ClinicalOptionService } from './clinicaloption.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const clinicalOptionService = new ClinicalOptionService();

export async function listClinicalOptions(req: Request, res: Response, next: NextFunction) {
  try {
    const options = await clinicalOptionService.list();
    return res.status(200).json(successResponse(200, 'Success', options));
  } catch (error) {
    next(error);
  }
}

export async function createClinicalOption(req: Request, res: Response, next: NextFunction) {
  try {
    const option = await clinicalOptionService.create(req.body);
    return res.status(201).json(successResponse(201, 'Clinical option created', option));
  } catch (error) {
    next(error);
  }
}

export async function updateClinicalOption(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const option = await clinicalOptionService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Clinical option updated', option));
  } catch (error) {
    next(error);
  }
}

export async function deleteClinicalOption(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await clinicalOptionService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
