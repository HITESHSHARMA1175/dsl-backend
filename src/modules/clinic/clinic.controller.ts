import { Request, Response, NextFunction } from 'express';
import { ClinicService } from './clinic.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const clinicService = new ClinicService(prisma);

export async function listClinics(req: Request, res: Response, next: NextFunction) {
  try {
    const clinics = await clinicService.list();
    return res.status(200).json(successResponse(200, 'Success', clinics));
  } catch (error) {
    next(error);
  }
}

export async function createClinic(req: Request, res: Response, next: NextFunction) {
  try {
    const clinic = await clinicService.create(req.body);
    return res.status(201).json(successResponse(201, 'Clinic created', clinic));
  } catch (error) {
    next(error);
  }
}

export async function updateClinic(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const clinic = await clinicService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Clinic updated', clinic));
  } catch (error) {
    next(error);
  }
}

export async function deleteClinic(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await clinicService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleClinicStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const clinic = await clinicService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', clinic));
  } catch (error) {
    next(error);
  }
}

// ==================== MOBILE (clinic detail) ENDPOINTS ====================

export async function getClinicInfo(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await clinicService.getInfo(id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function getClinicHxg(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await clinicService.getHxg(id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function getClinicTime(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const data = await clinicService.getTime(id);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function getClinicRooms(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await clinicService.getRooms();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function getClinicEquipments(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await clinicService.getEquipments();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function getClinicFinance(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await clinicService.getFinance();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}
