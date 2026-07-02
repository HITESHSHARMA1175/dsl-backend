import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createVendorSchema, updateVendorSchema } from './vendor.schema';
import {
  listVendors,
  createVendor,
  updateVendor,
  deleteVendor,
} from './vendor.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listVendors);
router.post('/', authMiddleware, adminGuard, validate(createVendorSchema), createVendor);
router.put('/:id', authMiddleware, adminGuard, validate(updateVendorSchema), updateVendor);
router.delete('/:id', authMiddleware, adminGuard, deleteVendor);

export default router;
