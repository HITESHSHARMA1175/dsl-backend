import { Request, Response, NextFunction } from 'express';
import { ConsultationFormService } from './consultationform.service';
import { successResponse } from '../../shared/utils/response.util';

const consultationFormService = new ConsultationFormService();

export async function listConsultationForms(req: Request, res: Response, next: NextFunction) {
  try {
    const forms = await consultationFormService.list();
    return res.status(200).json(successResponse(200, 'Success', forms));
  } catch (error) {
    next(error);
  }
}

export async function getConsultationFormById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const form = await consultationFormService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', form));
  } catch (error) {
    next(error);
  }
}

export async function getReferrals(req: Request, res: Response, next: NextFunction) {
  try {
    const referrals = await consultationFormService.getReferrals();
    return res.status(200).json(successResponse(200, 'Success', referrals));
  } catch (error) {
    next(error);
  }
}

export async function getSubscribed(req: Request, res: Response, next: NextFunction) {
  try {
    const subscribed = await consultationFormService.getSubscribed();
    return res.status(200).json(successResponse(200, 'Success', subscribed));
  } catch (error) {
    next(error);
  }
}

export async function submitConsultationForm(req: Request, res: Response, next: NextFunction) {
  try {
    const form = await consultationFormService.submit(req.body);
    return res.status(201).json(successResponse(201, 'Consultation form submitted successfully', form));
  } catch (error) {
    next(error);
  }
}
