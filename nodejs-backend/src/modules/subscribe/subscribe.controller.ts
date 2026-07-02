import { Request, Response, NextFunction } from 'express';
import { SubscribeService } from './subscribe.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const subscribeService = new SubscribeService(prisma);

export async function createSubscription(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await subscribeService.create(req.body);
    return res.status(201).json(successResponse(201, 'Subscribed successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function listSubscriptions(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const { items, total } = await subscribeService.list(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}
