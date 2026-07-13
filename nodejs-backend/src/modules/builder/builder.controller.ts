import { Request, Response, NextFunction } from 'express';
import { BuilderService } from './builder.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new BuilderService(prisma);

export async function listBuilders(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await service.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) { next(error); }
}

export async function createBuilder(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await service.create(req.body);
    return res.status(201).json(successResponse(201, 'Builder created', item));
  } catch (error) { next(error); }
}

export async function updateBuilder(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const item = await service.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Builder updated', item));
  } catch (error) { next(error); }
}

export async function deleteBuilder(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
