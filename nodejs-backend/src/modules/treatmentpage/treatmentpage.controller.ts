import { Request, Response, NextFunction } from 'express';
import { TreatmentPageService } from './treatmentpage.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const treatmentPageService = new TreatmentPageService(prisma);

export async function listTreatmentPages(req: Request, res: Response, next: NextFunction) {
  try {
    const pages = await treatmentPageService.list();
    return res.status(200).json(successResponse(200, 'Success', pages));
  } catch (error) {
    next(error);
  }
}

export async function listTreatmentPagesAdmin(req: Request, res: Response, next: NextFunction) {
  try {
    const pages = await treatmentPageService.listAdmin();
    return res.status(200).json(successResponse(200, 'Success', pages));
  } catch (error) {
    next(error);
  }
}

export async function getTreatmentPageBySlug(req: Request, res: Response, next: NextFunction) {
  try {
    const page = await treatmentPageService.getBySlug(String(req.params.slug));
    return res.status(200).json(successResponse(200, 'Success', page));
  } catch (error) {
    next(error);
  }
}

export async function getTreatmentPageById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', page));
  } catch (error) {
    next(error);
  }
}

export async function createTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const page = await treatmentPageService.create(req.body);
    return res.status(201).json(successResponse(201, 'Treatment page created', page));
  } catch (error) {
    next(error);
  }
}

export async function updateTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Treatment page updated', page));
  } catch (error) {
    next(error);
  }
}

export async function deleteTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await treatmentPageService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
