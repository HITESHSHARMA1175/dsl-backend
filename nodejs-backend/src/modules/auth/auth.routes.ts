import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { otpRateLimiter } from '../../middleware/rateLimiter.middleware';
import {
  adminLoginSchema,
  refreshTokenSchema,
  requestOtpSchema,
  verifyOtpSchema,
} from './auth.schema';
import {
  adminLogin,
  adminRefresh,
  requestOtp,
  verifyOtp,
  customerRefresh,
} from './auth.controller';

const router = Router();

// Admin routes
router.post('/admin/login', validate(adminLoginSchema), adminLogin);
router.post('/admin/refresh', validate(refreshTokenSchema), adminRefresh);

// Customer routes
router.post('/customer/request-otp', otpRateLimiter, validate(requestOtpSchema), requestOtp);
router.post('/customer/verify-otp', otpRateLimiter, validate(verifyOtpSchema), verifyOtp);
router.post('/customer/refresh', validate(refreshTokenSchema), customerRefresh);

export default router;
