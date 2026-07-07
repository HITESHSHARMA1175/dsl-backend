import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createBuilderSchema, updateBuilderSchema } from './builder.schema';
import { listBuilders, createBuilder, updateBuilder, deleteBuilder } from './builder.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listBuilders);
router.post('/', authMiddleware, adminGuard, validate(createBuilderSchema), createBuilder);
router.put('/:id', authMiddleware, adminGuard, validate(updateBuilderSchema), updateBuilder);
router.delete('/:id', authMiddleware, adminGuard, deleteBuilder);

export default router;
