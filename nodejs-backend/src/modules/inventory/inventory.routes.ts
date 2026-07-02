import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createInventorySchema, updateInventorySchema, createInventoryCategorySchema } from './inventory.schema';
import {
  listInventory,
  createInventory,
  updateInventory,
  deleteInventory,
  listInventoryCategories,
  createInventoryCategory,
} from './inventory.controller';

const router = Router();

router.get('/categories', authMiddleware, adminGuard, listInventoryCategories);
router.post('/categories', authMiddleware, adminGuard, validate(createInventoryCategorySchema), createInventoryCategory);
router.get('/', authMiddleware, adminGuard, listInventory);
router.post('/', authMiddleware, adminGuard, validate(createInventorySchema), createInventory);
router.put('/:id', authMiddleware, adminGuard, validate(updateInventorySchema), updateInventory);
router.delete('/:id', authMiddleware, adminGuard, deleteInventory);

export default router;
