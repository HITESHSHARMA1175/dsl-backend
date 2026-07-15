import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import {
  createTreatmentPageSchema,
  updateTreatmentPageSchema,
  createTreatmentFaqSchema,
  updateTreatmentFaqSchema,
  reorderTreatmentFaqSchema,
  createTreatmentReviewSchema,
  updateTreatmentReviewSchema,
  reorderTreatmentReviewSchema,
} from './treatmentpage.schema';
import {
  listTreatmentPages,
  listTreatmentPagesAdmin,
  getTreatmentPageBySlug,
  getTreatmentPageById,
  createTreatmentPage,
  updateTreatmentPage,
  deleteTreatmentPage,
  publishTreatmentPage,
  unpublishTreatmentPage,
  archiveTreatmentPage,
  addTreatmentFaq,
  updateTreatmentFaq,
  deleteTreatmentFaq,
  toggleTreatmentFaqStatus,
  reorderTreatmentFaqs,
  addTreatmentReview,
  updateTreatmentReview,
  deleteTreatmentReview,
  toggleTreatmentReviewStatus,
  reorderTreatmentReviews,
} from './treatmentpage.controller';

const router = Router();
const admin = [authMiddleware, adminGuard];

// ===== Admin: page CRUD + workflow (literal paths first, so they aren't swallowed by /:slug) =====
router.get('/admin/all', ...admin, listTreatmentPagesAdmin);
router.get('/admin/:id', ...admin, getTreatmentPageById);
router.post('/', ...admin, validate(createTreatmentPageSchema), createTreatmentPage);
router.put('/:id', ...admin, validate(updateTreatmentPageSchema), updateTreatmentPage);
router.delete('/:id', ...admin, deleteTreatmentPage);
router.patch('/:id/publish', ...admin, publishTreatmentPage);
router.patch('/:id/unpublish', ...admin, unpublishTreatmentPage);
router.patch('/:id/archive', ...admin, archiveTreatmentPage);

// ===== Admin: FAQs =====
router.post('/:id/faqs', ...admin, validate(createTreatmentFaqSchema), addTreatmentFaq);
router.patch('/:id/faqs/reorder', ...admin, validate(reorderTreatmentFaqSchema), reorderTreatmentFaqs);
router.put('/:id/faqs/:faqId', ...admin, validate(updateTreatmentFaqSchema), updateTreatmentFaq);
router.delete('/:id/faqs/:faqId', ...admin, deleteTreatmentFaq);
router.patch('/:id/faqs/:faqId/toggle-status', ...admin, toggleTreatmentFaqStatus);

// ===== Admin: Reviews =====
router.post('/:id/reviews', ...admin, validate(createTreatmentReviewSchema), addTreatmentReview);
router.patch('/:id/reviews/reorder', ...admin, validate(reorderTreatmentReviewSchema), reorderTreatmentReviews);
router.put('/:id/reviews/:reviewId', ...admin, validate(updateTreatmentReviewSchema), updateTreatmentReview);
router.delete('/:id/reviews/:reviewId', ...admin, deleteTreatmentReview);
router.patch('/:id/reviews/:reviewId/toggle-status', ...admin, toggleTreatmentReviewStatus);

// ===== Public =====
router.get('/', listTreatmentPages);
router.get('/:slug', getTreatmentPageBySlug);

export default router;
