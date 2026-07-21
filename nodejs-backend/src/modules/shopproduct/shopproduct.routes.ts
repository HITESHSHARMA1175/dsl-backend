import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createShopProductSchema, updateShopProductSchema } from './shopproduct.schema';
import {
  listPublicProducts,
  listAdminProducts,
  getProductById,
  createProduct,
  updateProduct,
  toggleProductStatus,
  deleteProduct,
} from './shopproduct.controller';

const router = Router();

// ── Public ────────────────────────────────────────────────────────────────
// Anyone can fetch active products for the shop page
router.get('/', listPublicProducts);

// ── Admin ─────────────────────────────────────────────────────────────────
// Admin management: list, create, update, toggle, delete
router.get('/admin', authMiddleware, adminGuard, listAdminProducts);
router.get('/:id', authMiddleware, adminGuard, getProductById);
router.post('/', authMiddleware, adminGuard, validate(createShopProductSchema), createProduct);
router.patch('/:id', authMiddleware, adminGuard, validate(updateShopProductSchema), updateProduct);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleProductStatus);
router.delete('/:id', authMiddleware, adminGuard, deleteProduct);

export default router;
