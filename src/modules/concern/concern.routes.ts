import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import { saveConcernsSchema } from './concern.schema';
import { getTypes, listConcerns, saveConcerns, getSavedConcerns } from './concern.controller';

const router = Router();

router.get('/types', authMiddleware, getTypes);
router.get('/', authMiddleware, listConcerns);
router.post('/', authMiddleware, validate(saveConcernsSchema), saveConcerns);
router.get('/saved/:patientId', authMiddleware, getSavedConcerns);

export default router;
