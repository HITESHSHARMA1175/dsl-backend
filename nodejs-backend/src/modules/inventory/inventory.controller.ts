import { Request, Response, NextFunction } from 'express';
import { InventoryService } from './inventory.service';
import { successResponse } from '../../shared/utils/response.util';

const inventoryService = new InventoryService();

export async function listInventory(req: Request, res: Response, next: NextFunction) {
  try {
    const items = await inventoryService.list();
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) {
    next(error);
  }
}

export async function createInventory(req: Request, res: Response, next: NextFunction) {
  try {
    const item = await inventoryService.create(req.body);
    return res.status(201).json(successResponse(201, 'Inventory item created', item));
  } catch (error) {
    next(error);
  }
}

export async function updateInventory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const item = await inventoryService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Inventory item updated', item));
  } catch (error) {
    next(error);
  }
}

export async function deleteInventory(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await inventoryService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function listInventoryCategories(req: Request, res: Response, next: NextFunction) {
  try {
    const categories = await inventoryService.listCategories();
    return res.status(200).json(successResponse(200, 'Success', categories));
  } catch (error) {
    next(error);
  }
}

export async function createInventoryCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const category = await inventoryService.createCategory(req.body);
    return res.status(201).json(successResponse(201, 'Inventory category created', category));
  } catch (error) {
    next(error);
  }
}
