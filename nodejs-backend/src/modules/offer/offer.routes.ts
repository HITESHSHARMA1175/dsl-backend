import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createOfferSchema, updateOfferSchema } from './offer.schema';
import {
  listPublicOffers,
  listAdminOffers,
  getOfferById,
  createOffer,
  updateOffer,
  toggleOfferStatus,
  deleteOffer,
} from './offer.controller';

const router = Router();

// ── Public ────────────────────────────────────────────────────────────────
// Anyone can view active offers
router.get('/', listPublicOffers);

// ── Admin ─────────────────────────────────────────────────────────────────
// Admin management: list, create, update, toggle status, delete
router.get('/admin', authMiddleware, adminGuard, listAdminOffers);
router.get('/:id', authMiddleware, adminGuard, getOfferById);
router.post('/', authMiddleware, adminGuard, validate(createOfferSchema), createOffer);
router.patch('/:id', authMiddleware, adminGuard, validate(updateOfferSchema), updateOffer);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleOfferStatus);
router.delete('/:id', authMiddleware, adminGuard, deleteOffer);

export default router;
