import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createServiceSchema, updateServiceSchema } from './service.schema';
import {
  listServices,
  createService,
  updateService,
  removeService,
  toggleServiceStatus,
} from './service.controller';

const router = Router();

// Public
router.get('/', listServices);

// Admin protected
router.post('/', authMiddleware, adminGuard, validate(createServiceSchema), createService);
router.put('/:id', authMiddleware, adminGuard, validate(updateServiceSchema), updateService);
router.delete('/:id', authMiddleware, adminGuard, removeService);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleServiceStatus);

export default router;
