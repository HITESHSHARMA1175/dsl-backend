import { Request, Response, NextFunction } from 'express';
import { SubadminService } from './subadmin.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const subadminService = new SubadminService(prisma);

export async function listSubadmins(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const search = (req.query.search as string) || undefined;
    const { items, total } = await subadminService.list(page, perPage, search);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getSubadminById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await subadminService.getById(id);
    return res.status(200).json(successResponse(200, 'Sub-admin details fetched successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function createSubadmin(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await subadminService.create(req.body);
    return res.status(201).json(successResponse(201, 'Sub-admin created successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function updateSubadmin(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await subadminService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Sub-admin updated successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function toggleSubadminStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await subadminService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled successfully', data));
  } catch (error) {
    next(error);
  }
}
