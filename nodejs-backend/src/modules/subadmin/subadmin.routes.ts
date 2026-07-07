import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createSubadminSchema, updateSubadminSchema } from './subadmin.schema';
import {
  listSubadmins,
  getSubadminById,
  createSubadmin,
  updateSubadmin,
  toggleSubadminStatus,
} from './subadmin.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listSubadmins);
router.post('/', authMiddleware, adminGuard, validate(createSubadminSchema), createSubadmin);
router.get('/:id', authMiddleware, adminGuard, getSubadminById);
router.put('/:id', authMiddleware, adminGuard, validate(updateSubadminSchema), updateSubadmin);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleSubadminStatus);

export default router;
