import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createServicecatSchema, updateServicecatSchema, sortingSchema } from './servicecat.schema';
import {
  listServicecats,
  getServicecatTree,
  getServicecatMenu,
  getServicecatById,
  createServicecat,
  updateServicecat,
  deleteServicecat,
  toggleServicecatStatus,
  updateServicecatSorting,
} from './servicecat.controller';

const router = Router();

// Public listing (literal paths before the /:id wildcard)
router.get('/', listServicecats);
router.get('/tree', getServicecatTree);
router.get('/menu', getServicecatMenu);

// Admin protected
router.post('/sorting', authMiddleware, adminGuard, validate(sortingSchema), updateServicecatSorting);
router.get('/:id', getServicecatById);
router.post('/', authMiddleware, adminGuard, validate(createServicecatSchema), createServicecat);
router.put('/:id', authMiddleware, adminGuard, validate(updateServicecatSchema), updateServicecat);
router.delete('/:id', authMiddleware, adminGuard, deleteServicecat);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleServicecatStatus);

export default router;
