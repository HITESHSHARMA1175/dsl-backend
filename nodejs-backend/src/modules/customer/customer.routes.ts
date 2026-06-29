import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { updateProfileSchema, createAddressSchema, updateAddressSchema } from './customer.schema';
import {
  getProfile,
  updateProfile,
  listAddresses,
  createAddress,
  updateAddress,
  getBookingHistory,
  getOrderHistory,
} from './customer.controller';

const router = Router();

// All routes require authentication (customer guard)
router.use(authMiddleware);

router.get('/profile', getProfile);
router.put('/profile', validate(updateProfileSchema), updateProfile);
router.get('/addresses', listAddresses);
router.post('/addresses', validate(createAddressSchema), createAddress);
router.put('/addresses/:id', validate(updateAddressSchema), updateAddress);
router.get('/bookings', getBookingHistory);
router.get('/orders', getOrderHistory);

export default router;
