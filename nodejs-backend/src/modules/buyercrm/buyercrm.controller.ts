import { Request, Response, NextFunction } from 'express';
import { BuyerCrmService } from './buyercrm.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new BuyerCrmService(prisma);

export async function listBuyerLeads(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Number(req.query.page) || 1;
    const perPage = Number(req.query.per_page) || 20;
    const result = await service.list(page, perPage);
    return res.status(200).json(paginatedResponse(result.items, result.total, result.page, result.perPage, '/api/v1/buyer-crm'));
  } catch (error) {
    next(error);
  }
}

export async function createBuyerLead(req: Request, res: Response, next: NextFunction) {
  try {
    const lead = await service.create(req.body);
    return res.status(201).json(successResponse(201, 'Buyer lead created', lead));
  } catch (error) {
    next(error);
  }
}

export async function getBuyerLeadById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const lead = await service.getById(id);
    return res.status(200).json(successResponse(200, 'Success', lead));
  } catch (error) {
    next(error);
  }
}

export async function updateBuyerLeadStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const { status, notes } = req.body;
    const lead = await service.updateStatus(id, status, notes);
    return res.status(200).json(successResponse(200, 'Status updated', lead));
  } catch (error) {
    next(error);
  }
}

export async function getBuyerLeadJourney(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const journey = await service.getJourney(id);
    return res.status(200).json(successResponse(200, 'Success', journey));
  } catch (error) {
    next(error);
  }
}
