import { Request, Response, NextFunction } from 'express';
import { SellerService } from './seller.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const sellerService = new SellerService(prisma);

export async function listSellers(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const filters = {
      search: (req.query.search as string) || undefined,
      kyc: (req.query.kyc as string) || undefined,
    };
    const { items, total } = await sellerService.list(page, perPage, filters);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getSellerKycList(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const { items, total } = await sellerService.kycList(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getSellerById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await sellerService.getById(id);
    return res.status(200).json(successResponse(200, 'Seller details fetched successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function createSeller(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await sellerService.create(req.body);
    return res.status(201).json(successResponse(201, 'Seller created successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function updateSeller(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await sellerService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Seller updated successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function toggleSellerStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await sellerService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled successfully', data));
  } catch (error) {
    next(error);
  }
}

export async function approveSellerKyc(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const data = await sellerService.approveKyc(id);
    return res.status(200).json(successResponse(200, 'KYC status updated successfully', data));
  } catch (error) {
    next(error);
  }
}
