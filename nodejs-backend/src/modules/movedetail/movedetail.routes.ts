import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createMoveDetailSchema, updateMoveDetailSchema } from './movedetail.schema';
import {
  listMoveDetails,
  createMoveDetail,
  getMoveDetailById,
  updateMoveDetail,
  deleteMoveDetail,
} from './movedetail.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listMoveDetails);
router.post('/', authMiddleware, adminGuard, validate(createMoveDetailSchema), createMoveDetail);
router.get('/:id', authMiddleware, adminGuard, getMoveDetailById);
router.put('/:id', authMiddleware, adminGuard, validate(updateMoveDetailSchema), updateMoveDetail);
router.delete('/:id', authMiddleware, adminGuard, deleteMoveDetail);

export default router;
