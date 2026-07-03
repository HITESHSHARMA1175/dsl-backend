import { Request, Response, NextFunction } from 'express';
import { ProfessionalService } from './professional.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const professionalService = new ProfessionalService(prisma);

export async function listProfessionals(req: Request, res: Response, next: NextFunction) {
  try {
    const professionals = await professionalService.list();
    return res.status(200).json(successResponse(200, 'Success', professionals));
  } catch (error) {
    next(error);
  }
}

export async function createProfessional(req: Request, res: Response, next: NextFunction) {
  try {
    const professional = await professionalService.create(req.body);
    return res.status(201).json(successResponse(201, 'Professional created', professional));
  } catch (error) {
    next(error);
  }
}

export async function updateProfessional(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const professional = await professionalService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Professional updated', professional));
  } catch (error) {
    next(error);
  }
}

export async function deleteProfessional(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await professionalService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleProfessionalStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const professional = await professionalService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Professional status toggled', professional));
  } catch (error) {
    next(error);
  }
}
