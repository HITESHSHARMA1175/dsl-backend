import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { customerGuard } from '../../middleware/customerGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { updateOrderAppointmentSchema, updateOrderStatusSchema } from './order.schema';
import {
  listOrders,
  getOrderById,
  updateOrderAppointment,
  updateOrderStatus,
  toggleOrderStatus,
  deleteOrder,
  getMyOrders,
  sendCustomEmail,
} from './order.controller';

const router = Router();

// ── Customer: own orders ────────────────────────────────────────────────────
router.get('/my-orders', authMiddleware, customerGuard, getMyOrders);

// ── Admin: all orders & custom email ───────────────────────────────────────
router.post('/send-custom-email', authMiddleware, adminGuard, sendCustomEmail);
router.get('/', authMiddleware, adminGuard, listOrders);
router.get('/:id', authMiddleware, adminGuard, getOrderById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateOrderStatusSchema), updateOrderStatus);
router.patch('/:id/appointment', authMiddleware, adminGuard, validate(updateOrderAppointmentSchema), updateOrderAppointment);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleOrderStatus);
router.delete('/:id', authMiddleware, adminGuard, deleteOrder);

export default router;
