import { Request, Response, NextFunction } from 'express';
import { ServiceService } from './service.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const serviceService = new ServiceService(prisma);

export async function listServices(req: Request, res: Response, next: NextFunction) {
  try {
    const propertyCategory = req.query.property_category !== undefined
      ? Number(req.query.property_category)
      : undefined;
    const propertySubCategory = req.query.property_sub_category !== undefined
      ? Number(req.query.property_sub_category)
      : undefined;
    const services = await serviceService.list(propertyCategory, propertySubCategory);
    return res.status(200).json(successResponse(200, 'Success', services));
  } catch (error) {
    next(error);
  }
}

export async function createService(req: Request, res: Response, next: NextFunction) {
  try {
    const service = await serviceService.create(req.body);
    return res.status(201).json(successResponse(201, 'Service created', service));
  } catch (error) {
    next(error);
  }
}

export async function updateService(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const service = await serviceService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Service updated', service));
  } catch (error) {
    next(error);
  }
}

export async function removeService(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    await serviceService.delete(id);
    return res.status(200).json(successResponse(200, 'Service deleted', null));
  } catch (error) {
    next(error);
  }
}

export async function toggleServiceStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const service = await serviceService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', service));
  } catch (error) {
    next(error);
  }
}
