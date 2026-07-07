import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createSellerSchema, updateSellerSchema } from './seller.schema';
import {
  listSellers,
  getSellerKycList,
  getSellerById,
  createSeller,
  updateSeller,
  toggleSellerStatus,
  approveSellerKyc,
} from './seller.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listSellers);
router.get('/kyc-list', authMiddleware, adminGuard, getSellerKycList);
router.post('/', authMiddleware, adminGuard, validate(createSellerSchema), createSeller);
router.get('/:id', authMiddleware, adminGuard, getSellerById);
router.put('/:id', authMiddleware, adminGuard, validate(updateSellerSchema), updateSeller);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleSellerStatus);
router.patch('/:id/kyc-approve', authMiddleware, adminGuard, approveSellerKyc);

export default router;
