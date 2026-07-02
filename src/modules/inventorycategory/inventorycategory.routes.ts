import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createInventoryCategorySchema, updateInventoryCategorySchema } from './inventorycategory.schema';
import {
  listInventoryCategories,
  createInventoryCategory,
  updateInventoryCategory,
  deleteInventoryCategory,
  getSubCategories,
} from './inventorycategory.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listInventoryCategories);
router.post('/', authMiddleware, adminGuard, validate(createInventoryCategorySchema), createInventoryCategory);
router.put('/:id', authMiddleware, adminGuard, validate(updateInventoryCategorySchema), updateInventoryCategory);
router.delete('/:id', authMiddleware, adminGuard, deleteInventoryCategory);
router.get('/sub', authMiddleware, adminGuard, getSubCategories);

export default router;
