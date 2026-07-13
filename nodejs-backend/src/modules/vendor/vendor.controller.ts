import { Request, Response, NextFunction } from 'express';
import { VendorService } from './vendor.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const vendorService = new VendorService();

export async function listVendors(req: Request, res: Response, next: NextFunction) {
  try {
    const vendors = await vendorService.list();
    return res.status(200).json(successResponse(200, 'Success', vendors));
  } catch (error) {
    next(error);
  }
}

export async function createVendor(req: Request, res: Response, next: NextFunction) {
  try {
    const vendor = await vendorService.create(req.body);
    return res.status(201).json(successResponse(201, 'Vendor created', vendor));
  } catch (error) {
    next(error);
  }
}

export async function updateVendor(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const vendor = await vendorService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Vendor updated', vendor));
  } catch (error) {
    next(error);
  }
}

export async function deleteVendor(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await vendorService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
