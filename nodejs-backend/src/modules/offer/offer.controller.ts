import { Request, Response, NextFunction } from 'express';
import { OfferService } from './offer.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const offerService = new OfferService(prisma);

/** Public: list active offers */
export async function listPublicOffers(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await offerService.listPublic();
    return res.status(200).json(successResponse(200, 'Offers fetched successfully', items));
  } catch (error) {
    next(error);
  }
}

/** Admin: list all offers with pagination */
export async function listAdminOffers(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 20);
    const search = (req.query.search as string) || undefined;
    const { items, total } = await offerService.listAdmin(page, perPage, search);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

/** Admin: get single offer */
export async function getOfferById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const offer = await offerService.getById(id);
    return res.status(200).json(successResponse(200, 'Offer fetched successfully', offer));
  } catch (error) {
    next(error);
  }
}

/** Admin: create offer */
export async function createOffer(req: Request, res: Response, next: NextFunction) {
  try {
    const offer = await offerService.create(req.body);
    return res.status(201).json(successResponse(201, 'Offer created successfully', offer));
  } catch (error) {
    next(error);
  }
}

/** Admin: update offer */
export async function updateOffer(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const offer = await offerService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Offer updated successfully', offer));
  } catch (error) {
    next(error);
  }
}

/** Admin: toggle offer active/inactive status */
export async function toggleOfferStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const offer = await offerService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Offer status updated', offer));
  } catch (error) {
    next(error);
  }
}

/** Admin: delete offer */
export async function deleteOffer(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await offerService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
