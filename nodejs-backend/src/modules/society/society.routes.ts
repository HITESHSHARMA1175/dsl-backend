import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createSocietySchema, updateSocietySchema } from './society.schema';
import { listSocieties, createSociety, updateSociety, deleteSociety } from './society.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listSocieties);
router.post('/', authMiddleware, adminGuard, validate(createSocietySchema), createSociety);
router.put('/:id', authMiddleware, adminGuard, validate(updateSocietySchema), updateSociety);
router.delete('/:id', authMiddleware, adminGuard, deleteSociety);

export default router;
