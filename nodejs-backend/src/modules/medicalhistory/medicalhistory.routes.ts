import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createMedicalHistorySchema, updateMedicalHistorySchema } from './medicalhistory.schema';
import {
  listMedicalHistories,
  createMedicalHistory,
  updateMedicalHistory,
  deleteMedicalHistory,
} from './medicalhistory.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listMedicalHistories);
router.post('/', authMiddleware, adminGuard, validate(createMedicalHistorySchema), createMedicalHistory);
router.put('/:id', authMiddleware, adminGuard, validate(updateMedicalHistorySchema), updateMedicalHistory);
router.delete('/:id', authMiddleware, adminGuard, deleteMedicalHistory);

export default router;
