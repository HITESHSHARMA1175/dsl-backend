import { Request, Response, NextFunction } from 'express';
import { OwnerService } from './owner.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new OwnerService(prisma);

export async function listOwners(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await service.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) { next(error); }
}

export async function createOwner(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await service.create(req.body);
    return res.status(201).json(successResponse(201, 'Owner created', item));
  } catch (error) { next(error); }
}

export async function updateOwner(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const item = await service.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Owner updated', item));
  } catch (error) { next(error); }
}

export async function deleteOwner(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await service.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
