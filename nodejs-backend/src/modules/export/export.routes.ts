import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { exportLeads, exportData } from './export.controller';

const router = Router();

router.get('/leads', authMiddleware, adminGuard, exportLeads);
router.get('/data', authMiddleware, adminGuard, exportData);

export default router;
