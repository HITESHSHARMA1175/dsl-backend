import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createRedUrlSchema, updateRedUrlSchema } from './redurl.schema';
import {
  listRedUrls,
  createRedUrl,
  updateRedUrl,
  deleteRedUrl,
} from './redurl.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listRedUrls);
router.post('/', authMiddleware, adminGuard, validate(createRedUrlSchema), createRedUrl);
router.put('/:id', authMiddleware, adminGuard, validate(updateRedUrlSchema), updateRedUrl);
router.delete('/:id', authMiddleware, adminGuard, deleteRedUrl);

export default router;
