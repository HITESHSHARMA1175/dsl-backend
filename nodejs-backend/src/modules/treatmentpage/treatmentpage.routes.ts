import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createTreatmentPageSchema, updateTreatmentPageSchema } from './treatmentpage.schema';
import {
  listTreatmentPages,
  listTreatmentPagesAdmin,
  getTreatmentPageBySlug,
  getTreatmentPageById,
  createTreatmentPage,
  updateTreatmentPage,
  deleteTreatmentPage,
} from './treatmentpage.controller';

const router = Router();

// ===== Admin (literal paths first, so they aren't swallowed by /:slug) =====
router.get('/admin/all', authMiddleware, adminGuard, listTreatmentPagesAdmin);
router.get('/admin/:id', authMiddleware, adminGuard, getTreatmentPageById);
router.post('/', authMiddleware, adminGuard, validate(createTreatmentPageSchema), createTreatmentPage);
router.put('/:id', authMiddleware, adminGuard, validate(updateTreatmentPageSchema), updateTreatmentPage);
router.delete('/:id', authMiddleware, adminGuard, deleteTreatmentPage);

// ===== Public =====
router.get('/', listTreatmentPages);
router.get('/:slug', getTreatmentPageBySlug);

export default router;
