import { Request, Response, NextFunction } from 'express';
import { RedUrlService } from './redurl.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const redUrlService = new RedUrlService();

export async function listRedUrls(req: Request, res: Response, next: NextFunction) {
  try {
    const urls = await redUrlService.list();
    return res.status(200).json(successResponse(200, 'Success', urls));
  } catch (error) {
    next(error);
  }
}

export async function createRedUrl(req: Request, res: Response, next: NextFunction) {
  try {
    const url = await redUrlService.create(req.body);
    return res.status(201).json(successResponse(201, 'Redirect URL created', url));
  } catch (error) {
    next(error);
  }
}

export async function updateRedUrl(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const url = await redUrlService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Redirect URL updated', url));
  } catch (error) {
    next(error);
  }
}

export async function deleteRedUrl(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await redUrlService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
