import { Router } from 'express';
import { getValues } from './master.controller';

const router = Router();

// Public endpoint - no auth required
router.get('/values', getValues);

export default router;
