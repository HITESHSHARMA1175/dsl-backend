import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import {
  adminLoginSchema,
  customerLoginSchema,
  customerRegisterSchema,
  forgotPasswordSchema,
  resetPasswordSchema,
  changePasswordSchema,
  refreshTokenSchema,
} from './auth.schema';
import {
  adminLogin,
  adminRefresh,
  customerLogin,
  customerRegister,
  forgotPassword,
  resetPassword,
  changePassword,
  customerRefresh,
  logout,
} from './auth.controller';

const router = Router();

// ===== Admin =====
router.post('/admin/login', validate(adminLoginSchema), adminLogin);
router.post('/admin/refresh', validate(refreshTokenSchema), adminRefresh);

// ===== Customer =====
router.post('/customer/register', validate(customerRegisterSchema), customerRegister);
router.post('/customer/login', validate(customerLoginSchema), customerLogin);
router.post('/customer/refresh', validate(refreshTokenSchema), customerRefresh);

// ===== Forgot / Reset Password =====
router.post('/forgot-password', validate(forgotPasswordSchema), forgotPassword);
router.post('/reset-password', validate(resetPasswordSchema), resetPassword);

// ===== Change Password (authenticated) =====
router.post('/change-password', authMiddleware, validate(changePasswordSchema), changePassword);

// ===== Logout (authenticated) =====
router.post('/logout', authMiddleware, validate(refreshTokenSchema), logout);

export default router;
