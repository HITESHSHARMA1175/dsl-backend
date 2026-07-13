import { Request, Response, NextFunction } from 'express';
import { InventoryCategoryService } from './inventorycategory.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new InventoryCategoryService(prisma);

export async function listInventoryCategories(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await service.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) { next(error); }
}

export async function createInventoryCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await service.create(req.body);
    return res.status(201).json(successResponse(201, 'Inventory category created', item));
  } catch (error) { next(error); }
}

export async function updateInventoryCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const item = await service.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Inventory category updated', item));
  } catch (error) { next(error); }
}

export async function deleteInventoryCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function getSubCategories(req: Request, res: Response, next: NextFunction) {
  try {
    const parentId = Number(req.query.parent_id) || 0;
    const items = await service.getSubCategories(parentId);
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) { next(error); }
}
