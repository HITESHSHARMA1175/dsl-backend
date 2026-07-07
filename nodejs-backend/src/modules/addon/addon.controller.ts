import { Request, Response, NextFunction } from 'express';
import { AddonService } from './addon.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const addonService = new AddonService(prisma);

export async function listAddons(req: Request, res: Response, next: NextFunction) {
  try {
    const parentId = req.query.parent_id ? Number(req.query.parent_id) : undefined;
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);

    const { items, total } = await addonService.list(parentId, page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;

    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function createAddon(req: Request, res: Response, next: NextFunction) {
  try {
    const addon = await addonService.create(req.body);
    return res.status(201).json(successResponse(201, 'Addon created successfully', addon));
  } catch (error) {
    next(error);
  }
}

export async function updateAddon(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const addon = await addonService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Addon updated successfully', addon));
  } catch (error) {
    next(error);
  }
}

export async function deleteAddon(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await addonService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleAddonStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const addon = await addonService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Addon status toggled successfully', addon));
  } catch (error) {
    next(error);
  }
}
