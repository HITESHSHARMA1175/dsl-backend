import { Request, Response, NextFunction } from 'express';
import { LeadService } from './lead.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const leadService = new LeadService(prisma);

export async function createLead(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await leadService.create(req.body, req.user!.id);
    return res.status(200).json(successResponse(200, 'Lead created successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function listLeads(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const filters = {
      status: (req.query.status as string) || undefined,
      assign_emp: (req.query.assign_emp as string) || undefined,
      source: (req.query.source as string) || undefined,
    };

    const { items, total } = await leadService.list(page, perPage, filters);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;

    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getLeadById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const lead = await leadService.getById(id);
    return res.status(200).json(successResponse(200, 'Lead details fetched successfully', lead));
  } catch (error) {
    next(error);
  }
}

export async function updateLeadStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const { status, notes } = req.body;
    const result = await leadService.updateStatus(id, status, notes, req.user!.id);
    return res.status(200).json(successResponse(200, 'Lead status updated successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function assignLead(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const { assign_emp } = req.body;
    const result = await leadService.assign(id, assign_emp, req.user!.id);
    return res.status(200).json(successResponse(200, 'Lead assigned successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function getLeadJourney(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const journey = await leadService.getJourney(id);
    return res.status(200).json(successResponse(200, 'Lead journey fetched successfully', journey));
  } catch (error) {
    next(error);
  }
}
