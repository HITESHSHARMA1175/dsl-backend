import { Request, Response, NextFunction } from 'express';
import { AttributeService } from './attribute.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const service = new AttributeService(prisma);

// Attributes
export async function listAttributes(req: Request, res: Response, next: NextFunction) {
  try {
    const attributes = await service.listAttributes();
    return res.status(200).json(successResponse(200, 'Success', attributes));
  } catch (error) {
    next(error);
  }
}

export async function createAttribute(req: Request, res: Response, next: NextFunction) {
  try {
    const attribute = await service.createAttribute(req.body);
    return res.status(201).json(successResponse(201, 'Attribute created', attribute));
  } catch (error) {
    next(error);
  }
}

export async function updateAttribute(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const attribute = await service.updateAttribute(id, req.body);
    return res.status(200).json(successResponse(200, 'Attribute updated', attribute));
  } catch (error) {
    next(error);
  }
}

export async function deleteAttribute(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.deleteAttribute(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

// Attribute Values
export async function listValues(req: Request, res: Response, next: NextFunction) {
  try {
    const values = await service.listValues();
    return res.status(200).json(successResponse(200, 'Success', values));
  } catch (error) {
    next(error);
  }
}

export async function createValue(req: Request, res: Response, next: NextFunction) {
  try {
    const value = await service.createValue(req.body);
    return res.status(201).json(successResponse(201, 'Attribute value created', value));
  } catch (error) {
    next(error);
  }
}

export async function updateValue(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const value = await service.updateValue(id, req.body);
    return res.status(200).json(successResponse(200, 'Attribute value updated', value));
  } catch (error) {
    next(error);
  }
}

export async function deleteValue(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await service.deleteValue(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

// Map to category
export async function mapToCategory(req: Request, res: Response, next: NextFunction) {
  try {
    const { category_id, attribute_ids } = req.body;
    const result = await service.mapToCategory(category_id, attribute_ids);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
