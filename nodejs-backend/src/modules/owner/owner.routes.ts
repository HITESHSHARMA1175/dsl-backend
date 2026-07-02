import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createOwnerSchema, updateOwnerSchema } from './owner.schema';
import { listOwners, createOwner, updateOwner, deleteOwner } from './owner.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listOwners);
router.post('/', authMiddleware, adminGuard, validate(createOwnerSchema), createOwner);
router.put('/:id', authMiddleware, adminGuard, validate(updateOwnerSchema), updateOwner);
router.delete('/:id', authMiddleware, adminGuard, deleteOwner);

export default router;
