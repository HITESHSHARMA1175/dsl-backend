import { Request, Response, NextFunction } from 'express';
import { CategoryService } from './category.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const categoryService = new CategoryService(prisma);

export async function listCategories(req: Request, res: Response, next: NextFunction) {
  try {
    const parentId = req.query.parent_id !== undefined
      ? Number(req.query.parent_id)
      : 0;
    const categories = await categoryService.list(parentId);
    return res.status(200).json(successResponse(200, 'Success', categories));
  } catch (error) {
    next(error);
  }
}

export async function createCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const category = await categoryService.create(req.body);
    return res.status(201).json(successResponse(201, 'Category created', category));
  } catch (error) {
    next(error);
  }
}

export async function updateCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const category = await categoryService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Category updated', category));
  } catch (error) {
    next(error);
  }
}

export async function deleteCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await categoryService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
