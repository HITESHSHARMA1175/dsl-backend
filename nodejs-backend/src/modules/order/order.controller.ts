import { Request, Response, NextFunction } from 'express';
import { OrderService } from './order.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const orderService = new OrderService(prisma);

export async function listOrders(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const filters = {
      search: (req.query.search as string) || undefined,
      status: (req.query.status as string) || undefined,
    };
    const { items, total } = await orderService.list(page, perPage, filters);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getOrderById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const order = await orderService.getById(id);
    return res.status(200).json(successResponse(200, 'Order details fetched successfully', order));
  } catch (error) {
    next(error);
  }
}

export async function updateOrderStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const { order_status } = req.body;
    const result = await orderService.updateStatus(id, order_status);
    return res.status(200).json(successResponse(200, 'Order status updated successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function toggleOrderStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await orderService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Order status toggled successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function deleteOrder(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await orderService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
