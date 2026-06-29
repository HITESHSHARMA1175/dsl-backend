import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createProfessionalSchema, updateProfessionalSchema } from './professional.schema';
import {
  listProfessionals,
  createProfessional,
  updateProfessional,
  deleteProfessional,
  toggleProfessionalStatus,
} from './professional.controller';

const router = Router();

// Public
router.get('/', listProfessionals);

// Admin protected
router.post('/', authMiddleware, adminGuard, validate(createProfessionalSchema), createProfessional);
router.put('/:id', authMiddleware, adminGuard, validate(updateProfessionalSchema), updateProfessional);
router.delete('/:id', authMiddleware, adminGuard, deleteProfessional);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleProfessionalStatus);

export default router;
