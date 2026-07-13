import { Request, Response, NextFunction } from 'express';
import { DesignationService } from './designation.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new DesignationService(prisma);

export async function listDesignations(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await service.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) { next(error); }
}

export async function createDesignation(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await service.create(req.body);
    return res.status(201).json(successResponse(201, 'Designation created', item));
  } catch (error) { next(error); }
}

export async function updateDesignation(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const item = await service.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Designation updated', item));
  } catch (error) { next(error); }
}

export async function deleteDesignation(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
