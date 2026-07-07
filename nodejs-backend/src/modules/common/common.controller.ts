import { Request, Response, NextFunction } from 'express';
import { CommonService } from './common.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new CommonService(prisma);

export async function getCountries(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getCountries();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getStates(req: Request, res: Response, next: NextFunction) {
  try {
    const countryId = Number(req.query.country_id) || 0;
    const data = await service.getStates(countryId);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getCities(req: Request, res: Response, next: NextFunction) {
  try {
    const stateId = Number(req.query.state_id) || 0;
    const data = await service.getCities(stateId);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getMasterValues(req: Request, res: Response, next: NextFunction) {
  try {
    const head = (req.query.head as string) || '';
    const data = await service.getMasterValuesByHead(head);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getStaff(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getStaff();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getTreatments(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getTreatments();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getRooms(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getRooms();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getStaticPage(req: Request, res: Response, next: NextFunction) {
  try {
    const slug = (req.query.slug as string) || '';
    const data = await service.getStaticPage(slug);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getEquipment(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getMasterValuesByHead('Equipment');
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getAppointmentType(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getMasterValuesByHead('Appointment Type');
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getTreatmentType(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getMasterValuesByHead('Treatment Type');
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getBusinessTypeList(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getMasterValuesByHead('Business Type');
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getBusinessCategoryList(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getMasterValuesByHead('Business Category');
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function getHelpSupport(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getStaticPage('help-support');
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function search(req: Request, res: Response, next: NextFunction) {
  try {
    const q = (req.query.q as string) || (req.query.search as string) || '';
    const data = await service.search(q);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}
