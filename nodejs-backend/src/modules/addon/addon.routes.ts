import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createAddonSchema, updateAddonSchema } from './addon.schema';
import {
  listAddons,
  createAddon,
  updateAddon,
  deleteAddon,
  toggleAddonStatus,
} from './addon.controller';

const router = Router();

// Public route — paginated listing with optional parent_id filter
router.get('/', listAddons);

// Admin-protected routes
router.post('/', authMiddleware, adminGuard, validate(createAddonSchema), createAddon);
router.put('/:id', authMiddleware, adminGuard, validate(updateAddonSchema), updateAddon);
router.delete('/:id', authMiddleware, adminGuard, deleteAddon);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleAddonStatus);

export default router;
