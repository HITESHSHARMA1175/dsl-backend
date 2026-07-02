import { Request, Response, NextFunction } from 'express';
import { ServicecatService } from './servicecat.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const servicecatService = new ServicecatService(prisma);

export async function listServicecats(req: Request, res: Response, next: NextFunction) {
  try {
    const parentId = req.query.parent_id !== undefined ? Number(req.query.parent_id) : undefined;
    const data = await servicecatService.list(parentId);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function getServicecatById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await servicecatService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function createServicecat(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await servicecatService.create(req.body);
    return res.status(201).json(successResponse(201, 'Service category created successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function updateServicecat(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await servicecatService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Service category updated successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function deleteServicecat(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await servicecatService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleServicecatStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await servicecatService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function updateServicecatSorting(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await servicecatService.updateSorting(req.body.items);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
