import { Request, Response, NextFunction } from 'express';
import { MobileService } from './mobile.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new MobileService(prisma);

// Brands
export async function listBrands(req: Request, res: Response, next: NextFunction) {
  try {
    const brands = await service.listBrands();
    return res.status(200).json(successResponse(200, 'Success', brands));
  } catch (error) { next(error); }
}
export async function createBrand(req: Request, res: Response, next: NextFunction) {
  try {
    const brand = await service.createBrand(req.body);
    return res.status(201).json(successResponse(201, 'Brand created', brand));
  } catch (error) { next(error); }
}
export async function updateBrand(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const brand = await service.updateBrand(id, req.body);
    return res.status(200).json(successResponse(200, 'Brand updated', brand));
  } catch (error) { next(error); }
}
export async function deleteBrand(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.deleteBrand(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

// Models
export async function listModels(req: Request, res: Response, next: NextFunction) {
  try {
    const models = await service.listModels();
    return res.status(200).json(successResponse(200, 'Success', models));
  } catch (error) { next(error); }
}
export async function createModel(req: Request, res: Response, next: NextFunction) {
  try {
    const model = await service.createModel(req.body);
    return res.status(201).json(successResponse(201, 'Model created', model));
  } catch (error) { next(error); }
}
export async function updateModel(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const model = await service.updateModel(id, req.body);
    return res.status(200).json(successResponse(200, 'Model updated', model));
  } catch (error) { next(error); }
}
export async function deleteModel(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.deleteModel(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

// Variants
export async function listVariants(req: Request, res: Response, next: NextFunction) {
  try {
    const variants = await service.listVariants();
    return res.status(200).json(successResponse(200, 'Success', variants));
  } catch (error) { next(error); }
}
export async function createVariant(req: Request, res: Response, next: NextFunction) {
  try {
    const variant = await service.createVariant(req.body);
    return res.status(201).json(successResponse(201, 'Variant created', variant));
  } catch (error) { next(error); }
}
export async function updateVariant(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const variant = await service.updateVariant(id, req.body);
    return res.status(200).json(successResponse(200, 'Variant updated', variant));
  } catch (error) { next(error); }
}
export async function deleteVariant(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.deleteVariant(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}

// Colours
export async function listColours(req: Request, res: Response, next: NextFunction) {
  try {
    const colours = await service.listColours();
    return res.status(200).json(successResponse(200, 'Success', colours));
  } catch (error) { next(error); }
}
export async function createColour(req: Request, res: Response, next: NextFunction) {
  try {
    const colour = await service.createColour(req.body);
    return res.status(201).json(successResponse(201, 'Colour created', colour));
  } catch (error) { next(error); }
}
export async function updateColour(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const colour = await service.updateColour(id, req.body);
    return res.status(200).json(successResponse(200, 'Colour updated', colour));
  } catch (error) { next(error); }
}
export async function deleteColour(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.deleteColour(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) { next(error); }
}
