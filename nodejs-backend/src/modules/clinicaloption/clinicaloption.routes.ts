import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createClinicalOptionSchema, updateClinicalOptionSchema } from './clinicaloption.schema';
import {
  listClinicalOptions,
  createClinicalOption,
  updateClinicalOption,
  deleteClinicalOption,
} from './clinicaloption.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listClinicalOptions);
router.post('/', authMiddleware, adminGuard, validate(createClinicalOptionSchema), createClinicalOption);
router.put('/:id', authMiddleware, adminGuard, validate(updateClinicalOptionSchema), updateClinicalOption);
router.delete('/:id', authMiddleware, adminGuard, deleteClinicalOption);

export default router;
