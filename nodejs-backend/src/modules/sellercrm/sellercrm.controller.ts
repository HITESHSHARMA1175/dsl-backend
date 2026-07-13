import { Request, Response, NextFunction } from 'express';
import { SellerCrmService } from './sellercrm.service';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const sellerCrmService = new SellerCrmService();

export async function listSellerLeads(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Number(req.query.page) || 1;
    const perPage = Number(req.query.perPage) || 20;
    const filters = {
      status: req.query.status as string,
      search: req.query.search as string,
    };
    const result = await sellerCrmService.list(page, perPage, filters);
    return res.status(200).json(
      paginatedResponse(result.items, result.total, result.page, result.perPage, '/api/v1/seller-crm')
    );
  } catch (error) {
    next(error);
  }
}

export async function createSellerLead(req: Request, res: Response, next: NextFunction) {
  try {
    const lead = await sellerCrmService.create(req.body);
    return res.status(201).json(successResponse(201, 'Seller lead created', lead));
  } catch (error) {
    next(error);
  }
}

export async function getSellerLeadById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const lead = await sellerCrmService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', lead));
  } catch (error) {
    next(error);
  }
}

export async function updateSellerLeadStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const { status, notes } = req.body;
    const lead = await sellerCrmService.updateStatus(id, status, notes);
    return res.status(200).json(successResponse(200, 'Status updated', lead));
  } catch (error) {
    next(error);
  }
}

export async function getSellerLeadJourney(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const journey = await sellerCrmService.getJourney(id);
    return res.status(200).json(successResponse(200, 'Success', journey));
  } catch (error) {
    next(error);
  }
}

// ==================== MOBILE FIELD-STAFF ENDPOINTS ====================

export async function assignedSellerData(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const { items, total } = await sellerCrmService.assignedSellerData(req.user!.id, page, perPage);
    return res.status(200).json(
      paginatedResponse(items, total, page, perPage, '/api/v1/seller-crm/field/assigned')
    );
  } catch (error) {
    next(error);
  }
}

export async function sellerDataDetails(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await sellerCrmService.sellerDataDetails(id);
    return res.status(200).json(successResponse(200, 'Success', result));
  } catch (error) {
    next(error);
  }
}

export async function sellerDataUpdate(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await sellerCrmService.sellerDataUpdate(req.user!.id, id, req.body);
    return res.status(200).json(successResponse(200, 'Seller lead updated', result));
  } catch (error) {
    next(error);
  }
}
