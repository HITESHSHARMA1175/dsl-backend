import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createBookingSchema, updateStatusSchema } from './booking.schema';
import {
  createBooking,
  listBookings,
  searchBookings,
  getBookingById,
  updateBookingStatus,
} from './booking.controller';

const router = Router();

// Public route — create a booking
router.post('/', validate(createBookingSchema), createBooking);

// Admin-protected routes
router.get('/', authMiddleware, adminGuard, listBookings);
router.get('/search', authMiddleware, adminGuard, searchBookings);
router.get('/:id', authMiddleware, adminGuard, getBookingById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateStatusSchema), updateBookingStatus);

export default router;
