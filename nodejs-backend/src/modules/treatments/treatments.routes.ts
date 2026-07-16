import { Router } from 'express';
import { getTreatmentsNavbar, getTreatmentBySlug } from './treatments.controller';

const router = Router();

// Public - literal path first so it isn't swallowed by the /:slug wildcard.
router.get('/navbar', getTreatmentsNavbar);
router.get('/:slug', getTreatmentBySlug);

export default router;
