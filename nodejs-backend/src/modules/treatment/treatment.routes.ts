import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createTreatmentSchema, updateTreatmentSchema } from './treatment.schema';
import {
  listTreatments,
  createTreatment,
  updateTreatment,
  deleteTreatment,
} from './treatment.controller';

const router = Router();

// All treatment routes require admin authentication
router.use(authMiddleware, adminGuard);

router.get('/', listTreatments);
router.post('/', validate(createTreatmentSchema), createTreatment);
router.put('/:id', validate(updateTreatmentSchema), updateTreatment);
router.delete('/:id', deleteTreatment);

export default router;
