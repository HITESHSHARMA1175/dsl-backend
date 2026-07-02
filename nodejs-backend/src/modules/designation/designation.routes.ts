import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createDesignationSchema, updateDesignationSchema } from './designation.schema';
import { listDesignations, createDesignation, updateDesignation, deleteDesignation } from './designation.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listDesignations);
router.post('/', authMiddleware, adminGuard, validate(createDesignationSchema), createDesignation);
router.put('/:id', authMiddleware, adminGuard, validate(updateDesignationSchema), updateDesignation);
router.delete('/:id', authMiddleware, adminGuard, deleteDesignation);

export default router;
