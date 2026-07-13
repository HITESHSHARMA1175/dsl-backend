import { Request, Response, NextFunction } from 'express';
import { CartService } from './cart.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const cartService = new CartService(prisma);

/**
 * Resolve a cart session key from the request. Prefers an explicit
 * `session` value (body or query), falling back to the client IP.
 */
function resolveSession(req: Request): string {
  return (
    (req.body?.session as string) ||
    (req.query.session as string) ||
    (req.headers['x-session-id'] as string) ||
    req.ip ||
    'guest'
  );
}

export async function getCart(req: Request, res: Response, next: NextFunction) {
  try {
    const sessionKey = resolveSession(req);
    const data = await cartService.list(sessionKey);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function addToCart(req: Request, res: Response, next: NextFunction) {
  try {
    const sessionKey = resolveSession(req);
    const ipAddress = req.ip || '0.0.0.0';
    const data = await cartService.add(sessionKey, ipAddress, req.body);
    return res.status(201).json(successResponse(201, 'Item added to cart', data));
  } catch (error) {
    next(error);
  }
}

export async function updateCartQty(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const qty = Number(req.body.qty);
    const data = await cartService.updateQty(id, qty);
    return res.status(200).json(successResponse(200, 'Cart updated', data));
  } catch (error) {
    next(error);
  }
}

export async function removeCartItem(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await cartService.remove(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function clearCart(req: Request, res: Response, next: NextFunction) {
  try {
    const sessionKey = resolveSession(req);
    const result = await cartService.clear(sessionKey);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function checkoutCart(req: Request, res: Response, next: NextFunction) {
  try {
    const sessionKey = resolveSession(req);
    const order = await cartService.checkout(sessionKey, req.body);
    return res.status(201).json(successResponse(201, 'Order placed successfully', order));
  } catch (error) {
    next(error);
  }
}
