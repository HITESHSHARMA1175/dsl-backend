import { Router } from 'express';
import { getAvailableSlots } from './slot.controller';

const router = Router();

// Public route — no auth required
router.get('/', getAvailableSlots);

export default router;
