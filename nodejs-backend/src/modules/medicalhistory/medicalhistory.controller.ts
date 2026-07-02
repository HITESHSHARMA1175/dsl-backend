import { Request, Response, NextFunction } from 'express';
import { MedicalHistoryService } from './medicalhistory.service';
import { successResponse } from '../../shared/utils/response.util';

const medicalHistoryService = new MedicalHistoryService();

export async function listMedicalHistories(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await medicalHistoryService.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) {
    next(error);
  }
}

export async function createMedicalHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await medicalHistoryService.create(req.body);
    return res.status(201).json(successResponse(201, 'Medical history created', item));
  } catch (error) {
    next(error);
  }
}

export async function updateMedicalHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const item = await medicalHistoryService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Medical history updated', item));
  } catch (error) {
    next(error);
  }
}

export async function deleteMedicalHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await medicalHistoryService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
