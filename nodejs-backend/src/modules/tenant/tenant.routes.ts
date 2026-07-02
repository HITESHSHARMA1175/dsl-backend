import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createTenantSchema, updateTenantSchema } from './tenant.schema';
import {
  listTenants,
  createTenant,
  updateTenant,
  deleteTenant,
  getImportTemplate,
  importTenants,
} from './tenant.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listTenants);
router.post('/', authMiddleware, adminGuard, validate(createTenantSchema), createTenant);
router.put('/:id', authMiddleware, adminGuard, validate(updateTenantSchema), updateTenant);
router.delete('/:id', authMiddleware, adminGuard, deleteTenant);
router.get('/import-template', authMiddleware, adminGuard, getImportTemplate);
router.post('/import', authMiddleware, adminGuard, importTenants);

export default router;
