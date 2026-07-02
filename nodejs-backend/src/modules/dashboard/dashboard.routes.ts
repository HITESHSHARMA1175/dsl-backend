import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { getDashboardStats } from './dashboard.controller';

const router = Router();

router.get('/stats', authMiddleware, adminGuard, getDashboardStats);

export default router;
