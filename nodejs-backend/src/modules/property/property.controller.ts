import { Request, Response, NextFunction } from 'express';
import { PropertyService } from './property.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const propertyService = new PropertyService(prisma);

// ---------- Public / mobile ----------

export async function getProperties(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const { items, total } = await propertyService.list(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getPropertyDetails(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await propertyService.getDetails(id);
    return res.status(200).json(successResponse(200, 'Property details', data));
  } catch (error) {
    next(error);
  }
}

export async function getPropertyRooms(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await propertyService.getRooms(id);
    return res.status(200).json(successResponse(200, 'Property room list', data));
  } catch (error) {
    next(error);
  }
}

export async function getRoomBeds(req: Request, res: Response, next: NextFunction) {
  try {
    const roomId = parseIdParam(req.params.roomId);
    const data = await propertyService.getRoomBeds(roomId);
    return res.status(200).json(successResponse(200, 'Room bed list', data));
  } catch (error) {
    next(error);
  }
}

// ---------- Admin ----------

export async function listAllProperties(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const search = (req.query.search as string) || undefined;
    const { items, total } = await propertyService.listAll(page, perPage, search);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function listPropertyRooms(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await propertyService.listPropertyRooms(id);
    return res.status(200).json(successResponse(200, 'Property rooms', data));
  } catch (error) {
    next(error);
  }
}

export async function deletePropertyRoom(req: Request, res: Response, next: NextFunction) {
  try {
    const roomId = parseIdParam(req.params.roomId);
    const result = await propertyService.deleteRoom(roomId);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function togglePropertyStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await propertyService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', data));
  } catch (error) {
    next(error);
  }
}

export async function togglePropertyOfferStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await propertyService.toggleOfferStatus(id);
    return res.status(200).json(successResponse(200, 'Offer status toggled', data));
  } catch (error) {
    next(error);
  }
}
