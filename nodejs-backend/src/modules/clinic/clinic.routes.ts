import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createClinicSchema, updateClinicSchema } from './clinic.schema';
import {
  listClinics,
  createClinic,
  updateClinic,
  deleteClinic,
  toggleClinicStatus,
} from './clinic.controller';

const router = Router();

// All routes are admin-protected
router.get('/', authMiddleware, adminGuard, listClinics);
router.post('/', authMiddleware, adminGuard, validate(createClinicSchema), createClinic);
router.put('/:id', authMiddleware, adminGuard, validate(updateClinicSchema), updateClinic);
router.delete('/:id', authMiddleware, adminGuard, deleteClinic);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleClinicStatus);

export default router;
