import { Request, Response, NextFunction } from 'express';
import { CustomerService } from './customer.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const customerService = new CustomerService(prisma);

export async function getProfile(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const customer = await customerService.getProfile(customerId);
    return res.status(200).json(successResponse(200, 'Success', customer));
  } catch (error) {
    next(error);
  }
}

export async function updateProfile(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const customer = await customerService.updateProfile(customerId, req.body);
    return res.status(200).json(successResponse(200, 'Profile updated', customer));
  } catch (error) {
    next(error);
  }
}

export async function listAddresses(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const addresses = await customerService.listAddresses(customerId);
    return res.status(200).json(successResponse(200, 'Success', addresses));
  } catch (error) {
    next(error);
  }
}

export async function createAddress(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const address = await customerService.createAddress(customerId, req.body);
    return res.status(201).json(successResponse(201, 'Address created', address));
  } catch (error) {
    next(error);
  }
}

export async function updateAddress(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const addressId = parseIdParam(req.params.id);
    const address = await customerService.updateAddress(customerId, addressId, req.body);
    return res.status(200).json(successResponse(200, 'Address updated', address));
  } catch (error) {
    next(error);
  }
}

export async function getBookingHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const bookings = await customerService.getBookingHistory(customerId);
    return res.status(200).json(successResponse(200, 'Success', bookings));
  } catch (error) {
    next(error);
  }
}

export async function getOrderHistory(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const orders = await customerService.getOrderHistory(customerId);
    return res.status(200).json(successResponse(200, 'Success', orders));
  } catch (error) {
    next(error);
  }
}

export async function getEmiList(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const emis = await customerService.getEmiList(customerId);
    return res.status(200).json(successResponse(200, 'Success', emis));
  } catch (error) {
    next(error);
  }
}

export async function addEmi(req: Request, res: Response, next: NextFunction) {
  try {
    const customerId = req.user!.id;
    const emi = await customerService.addEmi(customerId, req.body);
    return res.status(201).json(successResponse(201, 'EMI mandate added', emi));
  } catch (error) {
    next(error);
  }
}

export async function getBuyerList(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const search = (req.query.search as string) || undefined;
    const { items, total } = await customerService.getBuyerList(page, perPage, search);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}
