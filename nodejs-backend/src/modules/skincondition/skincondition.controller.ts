import { Request, Response, NextFunction } from 'express';
import { SkinConditionService } from './skincondition.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const skinConditionService = new SkinConditionService();

export async function listConditions(req: Request, res: Response, next: NextFunction) {
  try {
    const conditions = await skinConditionService.list();
    return res.status(200).json(successResponse(200, 'Success', conditions));
  } catch (error) {
    next(error);
  }
}

export async function createCondition(req: Request, res: Response, next: NextFunction) {
  try {
    const condition = await skinConditionService.create(req.body);
    return res.status(201).json(successResponse(201, 'Skin condition created', condition));
  } catch (error) {
    next(error);
  }
}

export async function updateCondition(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const condition = await skinConditionService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Skin condition updated', condition));
  } catch (error) {
    next(error);
  }
}

export async function deleteCondition(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await skinConditionService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleConditionStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const condition = await skinConditionService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', condition));
  } catch (error) {
    next(error);
  }
}

export async function updateSorting(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await skinConditionService.updateSorting(req.body.items);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

// Sub-conditions
export async function listSubConditions(req: Request, res: Response, next: NextFunction) {
  try {
    const conditions = await skinConditionService.listSub();
    return res.status(200).json(successResponse(200, 'Success', conditions));
  } catch (error) {
    next(error);
  }
}

export async function createSubCondition(req: Request, res: Response, next: NextFunction) {
  try {
    const condition = await skinConditionService.createSub(req.body);
    return res.status(201).json(successResponse(201, 'Sub-condition created', condition));
  } catch (error) {
    next(error);
  }
}

export async function updateSubCondition(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const condition = await skinConditionService.updateSub(id, req.body);
    return res.status(200).json(successResponse(200, 'Sub-condition updated', condition));
  } catch (error) {
    next(error);
  }
}

export async function deleteSubCondition(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await skinConditionService.deleteSub(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
