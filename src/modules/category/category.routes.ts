import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createCategorySchema, updateCategorySchema } from './category.schema';
import {
  listCategories,
  createCategory,
  updateCategory,
  deleteCategory,
} from './category.controller';

const router = Router();

// Public
router.get('/', listCategories);

// Admin protected
router.post('/', authMiddleware, adminGuard, validate(createCategorySchema), createCategory);
router.put('/:id', authMiddleware, adminGuard, validate(updateCategorySchema), updateCategory);
router.delete('/:id', authMiddleware, adminGuard, deleteCategory);

export default router;
