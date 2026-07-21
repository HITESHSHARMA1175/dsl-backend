import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { customerGuard } from '../../middleware/customerGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { updateOrderStatusSchema } from './order.schema';
import {
  listOrders,
  getOrderById,
  updateOrderStatus,
  toggleOrderStatus,
  deleteOrder,
  getMyOrders,
} from './order.controller';

const router = Router();

// ── Customer: own orders ────────────────────────────────────────────────────
router.get('/my-orders', authMiddleware, customerGuard, getMyOrders);

// ── Admin: all orders ───────────────────────────────────────────────────────
router.get('/', authMiddleware, adminGuard, listOrders);
router.get('/:id', authMiddleware, adminGuard, getOrderById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateOrderStatusSchema), updateOrderStatus);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleOrderStatus);
router.delete('/:id', authMiddleware, adminGuard, deleteOrder);

export default router;
