import { Request, Response, NextFunction } from 'express';
import { ImportService } from './import.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new ImportService(prisma);

export async function importData(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importData(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function importLeads(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importLeads(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function importProperties(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importProperties(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function importOwners(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importOwners(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function importTenants(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importTenants(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function importUsers(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importUsers(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function importSellers(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.importSellers(req.file);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
