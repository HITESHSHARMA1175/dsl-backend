import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createBuyerLeadSchema, updateBuyerLeadStatusSchema } from './buyercrm.schema';
import {
  listBuyerLeads,
  createBuyerLead,
  getBuyerLeadById,
  updateBuyerLeadStatus,
  getBuyerLeadJourney,
} from './buyercrm.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listBuyerLeads);
router.post('/', authMiddleware, adminGuard, validate(createBuyerLeadSchema), createBuyerLead);
router.get('/:id', authMiddleware, adminGuard, getBuyerLeadById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateBuyerLeadStatusSchema), updateBuyerLeadStatus);
router.get('/:id/journey', authMiddleware, adminGuard, getBuyerLeadJourney);

export default router;
