import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  createBannerSchema,
  updateBannerSchema,
  createReviewSchema,
  updateReviewSchema,
  createFaqSchema,
  updateFaqSchema,
  updateFaqSortingSchema,
  createBlogSchema,
  updateBlogSchema,
  createSeoSchema,
  updateSeoSchema,
} from './content.schema';
import {
  listBanners,
  createBanner,
  updateBanner,
  removeBanner,
  toggleBannerStatus,
  listReviews,
  createReview,
  updateReview,
  removeReview,
  toggleReviewStatus,
  listFaqs,
  createFaq,
  updateFaq,
  removeFaq,
  toggleFaqStatus,
  updateFaqSorting,
  listBlogs,
  createBlog,
  updateBlog,
  removeBlog,
  toggleBlogStatus,
  listSeo,
  createSeo,
  updateSeo,
  removeSeo,
} from './content.controller';

const router = Router();

// All content routes require admin authentication
const adminAuth = [authMiddleware, adminGuard];

// --- Banner Routes ---
router.get('/banners', ...adminAuth, listBanners);
router.post('/banners', ...adminAuth, validate(createBannerSchema), createBanner);
router.put('/banners/:id', ...adminAuth, validate(updateBannerSchema), updateBanner);
router.delete('/banners/:id', ...adminAuth, removeBanner);
router.patch('/banners/:id/toggle-status', ...adminAuth, toggleBannerStatus);

// --- Review Routes ---
router.get('/reviews', ...adminAuth, listReviews);
router.post('/reviews', ...adminAuth, validate(createReviewSchema), createReview);
router.put('/reviews/:id', ...adminAuth, validate(updateReviewSchema), updateReview);
router.delete('/reviews/:id', ...adminAuth, removeReview);
router.patch('/reviews/:id/toggle-status', ...adminAuth, toggleReviewStatus);

// --- FAQ Routes ---
router.get('/faqs', ...adminAuth, listFaqs);
router.post('/faqs', ...adminAuth, validate(createFaqSchema), createFaq);
router.put('/faqs/:id', ...adminAuth, validate(updateFaqSchema), updateFaq);
router.delete('/faqs/:id', ...adminAuth, removeFaq);
router.patch('/faqs/:id/toggle-status', ...adminAuth, toggleFaqStatus);
router.patch('/faqs/sorting', ...adminAuth, validate(updateFaqSortingSchema), updateFaqSorting);

// --- Blog Routes ---
router.get('/blogs', ...adminAuth, listBlogs);
router.post('/blogs', ...adminAuth, validate(createBlogSchema), createBlog);
router.put('/blogs/:id', ...adminAuth, validate(updateBlogSchema), updateBlog);
router.delete('/blogs/:id', ...adminAuth, removeBlog);
router.patch('/blogs/:id/toggle-status', ...adminAuth, toggleBlogStatus);

// --- SEO Routes ---
router.get('/seo', ...adminAuth, listSeo);
router.post('/seo', ...adminAuth, validate(createSeoSchema), createSeo);
router.put('/seo/:id', ...adminAuth, validate(updateSeoSchema), updateSeo);
router.delete('/seo/:id', ...adminAuth, removeSeo);

export default router;
