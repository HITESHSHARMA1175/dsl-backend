import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import {
  registerSchema,
  loginSchema,
  deviceTokenSchema,
  updateProfileSchema,
  updateKycSchema,
  updateBusinessSchema,
  updateAddressSchema,
} from './agent.schema';
import {
  register,
  login,
  updateDeviceToken,
  myProfile,
  updateProfile,
  kycDetails,
  updateKyc,
  getBusinessName,
  updateBusinessName,
  updateAddress,
  myPayment,
} from './agent.controller';

const router = Router();

// Public
router.post('/register', validate(registerSchema), register);
router.post('/login', validate(loginSchema), login);

// Authenticated (agent)
router.post('/device-token', authMiddleware, validate(deviceTokenSchema), updateDeviceToken);
router.get('/profile', authMiddleware, myProfile);
router.put('/profile', authMiddleware, validate(updateProfileSchema), updateProfile);
router.get('/kyc', authMiddleware, kycDetails);
router.put('/kyc', authMiddleware, validate(updateKycSchema), updateKyc);
router.get('/business', authMiddleware, getBusinessName);
router.put('/business', authMiddleware, validate(updateBusinessSchema), updateBusinessName);
router.put('/address', authMiddleware, validate(updateAddressSchema), updateAddress);
router.get('/payments', authMiddleware, myPayment);

export default router;
