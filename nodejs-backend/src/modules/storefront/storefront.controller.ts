import { Request, Response, NextFunction } from 'express';
import { StorefrontService } from './storefront.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const service = new StorefrontService(prisma);

/** Resolve the selection-session key from body/query/header. */
function sessionId(req: Request): string {
  return (
    (req.body?.system_id as string) ||
    (req.query.system_id as string) ||
    (req.headers['x-session-id'] as string) ||
    req.ip ||
    'guest'
  );
}

export async function getSelection(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.getSelection(sessionId(req));
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function addRemoveService(req: Request, res: Response, next: NextFunction) {
  try {
    const { sid, ssession, sprice, cat_id } = req.body;
    const data = await service.addRemoveService(sessionId(req), Number(sid), ssession, sprice, cat_id);
    return res.status(200).json(successResponse(200, `Service ${data.action}`, data));
  } catch (error) { next(error); }
}

export async function addRemoveAddon(req: Request, res: Response, next: NextFunction) {
  try {
    const { sid, ssession, sprice } = req.body;
    const data = await service.addRemoveAddon(sessionId(req), Number(sid), ssession, sprice);
    return res.status(200).json(successResponse(200, `Add-on ${data.action}`, data));
  } catch (error) { next(error); }
}

export async function addRemoveProduct(req: Request, res: Response, next: NextFunction) {
  try {
    const { sid, sprice, item } = req.body;
    const data = await service.addRemoveProduct(sessionId(req), Number(sid), sprice, item);
    return res.status(200).json(successResponse(200, `Product ${data.action}`, data));
  } catch (error) { next(error); }
}

export async function professionalTime(req: Request, res: Response, next: NextFunction) {
  try {
    const professionalId = Number(req.body.professional_id ?? req.query.professional_id);
    const date = (req.body.date ?? req.query.date) as string | undefined;
    const duration = req.body.total_service_duration ?? req.query.total_service_duration;
    const data = await service.professionalTime(sessionId(req), professionalId, date, duration ? Number(duration) : undefined);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}

export async function updateTimeSlot(req: Request, res: Response, next: NextFunction) {
  try {
    const { slot_id, slot_date, slot_time } = req.body;
    const data = await service.updateTimeSlot(sessionId(req), Number(slot_id), slot_date, slot_time);
    return res.status(200).json(successResponse(200, 'Time slot updated', data));
  } catch (error) { next(error); }
}

export async function saveSelectedData(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.saveSelectedData(sessionId(req), req.body);
    return res.status(200).json(successResponse(200, 'Selection saved', data));
  } catch (error) { next(error); }
}

export async function changeLanguage(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.changeLanguage(sessionId(req), req.body.language);
    return res.status(200).json(successResponse(200, 'Language updated', data));
  } catch (error) { next(error); }
}

export async function hidePopup(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await service.hidePopup(sessionId(req));
    return res.status(200).json(successResponse(200, 'Popup hidden', data));
  } catch (error) { next(error); }
}

export async function clearSelection(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await service.clear(sessionId(req));
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

export async function searchServices(req: Request, res: Response, next: NextFunction) {
  try {
    const q = (req.query.q as string) || (req.body?.search as string) || (req.query.search as string) || '';
    const data = await service.searchServices(q);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) { next(error); }
}
