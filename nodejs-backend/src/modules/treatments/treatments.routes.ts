import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createTreatmentContractSchema, updateTreatmentContractSchema } from './treatments.schema';
import {
  getTreatmentsNavbar,
  getTreatmentBySlug,
  createTreatmentPage,
  updateTreatmentPage,
} from './treatments.controller';

const router = Router();

// Public - literal paths first so they aren't swallowed by the /:slug wildcard.
router.get('/navbar', getTreatmentsNavbar);

// Admin - full page content in the frontend's exact { name, slug, pageData } contract.
// Mounted under /pages (not / or /:slug) to avoid colliding with the legacy
// admin-only POST // PUT /:id already defined on the separate `treatment`
// (booking lookup) module also mounted at this same /api/v1/treatments prefix.
router.post('/pages', authMiddleware, adminGuard, validate(createTreatmentContractSchema), createTreatmentPage);
router.put('/pages/:slug', authMiddleware, adminGuard, validate(updateTreatmentContractSchema), updateTreatmentPage);

router.get('/:slug', getTreatmentBySlug);

export default router;
