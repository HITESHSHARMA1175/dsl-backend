import { Request, Response, NextFunction } from 'express';
import { PatientService } from './patient.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const patientService = new PatientService(prisma);

export async function createPatient(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await patientService.create(req.body);
    return res.status(200).json(successResponse(200, 'Patient created successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function updatePatient(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await patientService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Patient updated successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function listPatients(req: Request, res: Response, next: NextFunction) {
  try {
    const searchText = (req.query.search_text as string) || undefined;
    const patients = await patientService.list(searchText);
    return res.status(200).json(successResponse(200, 'Patients fetched successfully', patients));
  } catch (error) {
    next(error);
  }
}

export async function getPatientById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const patient = await patientService.getById(id);
    return res.status(200).json(successResponse(200, 'Patient details fetched successfully', patient));
  } catch (error) {
    next(error);
  }
}

export async function getPatientTimeline(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const timeline = await patientService.getTimeline(id);
    return res.status(200).json(successResponse(200, 'Patient timeline fetched successfully', timeline));
  } catch (error) {
    next(error);
  }
}

export async function saveMedicalHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const patientId = Number(req.params.id);
    const { medical_history } = req.body;
    const result = await patientService.saveMedicalHistory(patientId, medical_history, req.user!.id);
    return res.status(200).json(successResponse(200, 'Medical history saved successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function getMedicalHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const patientId = Number(req.params.id);
    const records = await patientService.getMedicalHistory(patientId);
    return res.status(200).json(successResponse(200, 'Medical history fetched successfully', records));
  } catch (error) {
    next(error);
  }
}

export async function getPatientFinance(req: Request, res: Response, next: NextFunction) {
  try {
    const patientId = Number(req.params.id);
    const result = await patientService.getFinance(patientId);
    return res.status(200).json(successResponse(200, 'Patient finance fetched successfully', result));
  } catch (error) {
    next(error);
  }
}
