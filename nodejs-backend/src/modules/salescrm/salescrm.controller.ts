import { Request, Response, NextFunction } from 'express';
import { SalesCrmService } from './salescrm.service';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const salesCrmService = new SalesCrmService();

export async function listSalesLeads(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Number(req.query.page) || 1;
    const perPage = Number(req.query.perPage) || 20;
    const filters = {
      status: req.query.status as string,
      search: req.query.search as string,
    };
    const result = await salesCrmService.list(page, perPage, filters);
    return res.status(200).json(
      paginatedResponse(result.items, result.total, result.page, result.perPage, '/api/v1/sales-crm')
    );
  } catch (error) {
    next(error);
  }
}

export async function createSalesLead(req: Request, res: Response, next: NextFunction) {
  try {
    const lead = await salesCrmService.create(req.body);
    return res.status(201).json(successResponse(201, 'Sales lead created', lead));
  } catch (error) {
    next(error);
  }
}

export async function getSalesLeadById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const lead = await salesCrmService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', lead));
  } catch (error) {
    next(error);
  }
}

export async function updateSalesLeadStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const { status, notes } = req.body;
    const lead = await salesCrmService.updateStatus(id, status, notes);
    return res.status(200).json(successResponse(200, 'Status updated', lead));
  } catch (error) {
    next(error);
  }
}

export async function assignSalesLead(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const { empId } = req.body;
    const lead = await salesCrmService.assign(id, empId);
    return res.status(200).json(successResponse(200, 'Lead assigned', lead));
  } catch (error) {
    next(error);
  }
}

export async function getSalesLeadJourney(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const journey = await salesCrmService.getJourney(id);
    return res.status(200).json(successResponse(200, 'Success', journey));
  } catch (error) {
    next(error);
  }
}

// ==================== MOBILE FIELD-STAFF ENDPOINTS ====================

export async function scheduleVisit(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await salesCrmService.scheduleVisit(req.user!.id, req.body);
    return res.status(201).json(successResponse(201, 'Visit scheduled', result));
  } catch (error) {
    next(error);
  }
}

export async function tokenCollected(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await salesCrmService.tokenCollected(req.user!.id, req.body);
    return res.status(201).json(successResponse(201, 'Token collected', result));
  } catch (error) {
    next(error);
  }
}

export async function getScheduleToken(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await salesCrmService.getScheduleToken(req.user!.id);
    return res.status(200).json(successResponse(200, 'Success', result));
  } catch (error) {
    next(error);
  }
}

export async function getTokenCollected(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await salesCrmService.getTokenCollected(req.user!.id);
    return res.status(200).json(successResponse(200, 'Success', result));
  } catch (error) {
    next(error);
  }
}

export async function getScheduleTokenDetails(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await salesCrmService.getScheduleTokenDetails(id);
    return res.status(200).json(successResponse(200, 'Success', result));
  } catch (error) {
    next(error);
  }
}
