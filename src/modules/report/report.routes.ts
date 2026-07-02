import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  getCustomers,
  getEmiList,
  getActiveEmi,
  getPendingEmi,
  getBounceEmi,
} from './report.controller';

const router = Router();

router.get('/customers', authMiddleware, adminGuard, getCustomers);
router.get('/emi-list', authMiddleware, adminGuard, getEmiList);
router.get('/active-emi', authMiddleware, adminGuard, getActiveEmi);
router.get('/pending-emi', authMiddleware, adminGuard, getPendingEmi);
router.get('/bounce-emi', authMiddleware, adminGuard, getBounceEmi);

export default router;
