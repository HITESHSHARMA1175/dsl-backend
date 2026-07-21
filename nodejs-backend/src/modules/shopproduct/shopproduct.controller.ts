import { Request, Response, NextFunction } from 'express';
import { ShopProductService } from './shopproduct.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const shopProductService = new ShopProductService(prisma);

/** Public: list active products */
export async function listPublicProducts(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await shopProductService.listPublic();
    return res.status(200).json(successResponse(200, 'Products fetched successfully', items));
  } catch (error) {
    next(error);
  }
}

/** Admin: list all products with pagination */
export async function listAdminProducts(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 20);
    const search = (req.query.search as string) || undefined;
    const { items, total } = await shopProductService.listAdmin(page, perPage, search);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

/** Admin: get single product by ID */
export async function getProductById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const product = await shopProductService.getById(id);
    return res.status(200).json(successResponse(200, 'Product fetched successfully', product));
  } catch (error) {
    next(error);
  }
}

/** Admin: create product */
export async function createProduct(req: Request, res: Response, next: NextFunction) {
  try {
    const product = await shopProductService.create(req.body);
    return res.status(201).json(successResponse(201, 'Product created successfully', product));
  } catch (error) {
    next(error);
  }
}

/** Admin: update product */
export async function updateProduct(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const product = await shopProductService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Product updated successfully', product));
  } catch (error) {
    next(error);
  }
}

/** Admin: toggle product active/inactive */
export async function toggleProductStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const product = await shopProductService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Product status toggled', product));
  } catch (error) {
    next(error);
  }
}

/** Admin: delete product */
export async function deleteProduct(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await shopProductService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
