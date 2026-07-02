import { Request, Response, NextFunction } from 'express';
import { DataCrmService } from './datacrm.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const dataCrmService = new DataCrmService(prisma);

export async function listData(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const filters = {
      status: (req.query.status as string) || undefined,
      assign_emp: req.query.assign_emp ? Number(req.query.assign_emp) : undefined,
      search: (req.query.search as string) || undefined,
    };
    const { items, total } = await dataCrmService.list(page, perPage, filters);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getDataById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await dataCrmService.getById(id);
    return res.status(200).json(successResponse(200, 'Data details fetched successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function createData(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await dataCrmService.create(req.body, req.user!.id);
    return res.status(201).json(successResponse(201, 'Data record created successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function updateData(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await dataCrmService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Data record updated successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function updateDataStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const { status, remark } = req.body;
    const data = await dataCrmService.updateStatus(id, status, remark, req.user!.id);
    return res.status(200).json(successResponse(200, 'Data status updated successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function assignData(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const { assign_emp } = req.body;
    const data = await dataCrmService.assign(id, assign_emp, req.user!.id);
    return res.status(200).json(successResponse(200, 'Data assigned successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function markDataDead(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await dataCrmService.markDead(id, req.user!.id);
    return res.status(200).json(successResponse(200, 'Data marked as dead', data));
  } catch (error) {
    next(error);
  }
}

export async function getDataJourney(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const journey = await dataCrmService.getJourney(id);
    return res.status(200).json(successResponse(200, 'Data journey fetched successfully', journey));
  } catch (error) {
    next(error);
  }
}

export async function getDataImportLogs(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const { items, total } = await dataCrmService.getImportLogs(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getDataImportErrors(req: Request, res: Response, next: NextFunction) {
  try {
    const importId = Number(req.params.id);
    const errors = await dataCrmService.getImportErrors(importId);
    return res.status(200).json(successResponse(200, 'Import errors fetched successfully', errors));
  } catch (error) {
    next(error);
  }
}
