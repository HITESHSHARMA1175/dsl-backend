import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createSalesLeadSchema, updateStatusSchema, assignLeadSchema } from './salescrm.schema';
import {
  listSalesLeads,
  createSalesLead,
  getSalesLeadById,
  updateSalesLeadStatus,
  assignSalesLead,
  getSalesLeadJourney,
  scheduleVisit,
  tokenCollected,
  getScheduleToken,
  getTokenCollected,
  getScheduleTokenDetails,
} from './salescrm.controller';

const router = Router();

// ----- Mobile field-staff endpoints (any authenticated user) -----
router.post('/field/schedule-visit', authMiddleware, scheduleVisit);
router.post('/field/token-collected', authMiddleware, tokenCollected);
router.get('/field/schedule-token', authMiddleware, getScheduleToken);
router.get('/field/token-collected', authMiddleware, getTokenCollected);
router.get('/field/details/:id', authMiddleware, getScheduleTokenDetails);

// ----- Admin lead management -----
router.get('/', authMiddleware, adminGuard, listSalesLeads);
router.post('/', authMiddleware, adminGuard, validate(createSalesLeadSchema), createSalesLead);
router.get('/:id', authMiddleware, adminGuard, getSalesLeadById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateStatusSchema), updateSalesLeadStatus);
router.patch('/:id/assign', authMiddleware, adminGuard, validate(assignLeadSchema), assignSalesLead);
router.get('/:id/journey', authMiddleware, adminGuard, getSalesLeadJourney);

export default router;
