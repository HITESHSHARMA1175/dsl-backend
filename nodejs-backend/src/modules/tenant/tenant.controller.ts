import { Request, Response, NextFunction } from 'express';
import { TenantService } from './tenant.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new TenantService(prisma);

export async function listTenants(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await service.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) { next(error); }
}

export async function createTenant(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await service.create(req.body);
    return res.status(201).json(successResponse(201, 'Tenant created', item));
  } catch (error) { next(error); }
}

export async function updateTenant(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const item = await service.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Tenant updated', item));
  } catch (error) { next(error); }
}

export async function deleteTenant(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function getImportTemplate(req: Request, res: Response, next: NextFunction) {
  try {
    const template = await service.getImportTemplate();
    return res.status(200).json(successResponse(200, 'Success', template));
  } catch (error) { next(error); }
}

export async function importTenants(req: Request, res: Response, next: NextFunction) {
  try {
    const data = req.body.data || [];
    const result = await service.importTenants(data);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
