import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createLeadSchema, updateStatusSchema, assignLeadSchema } from './lead.schema';
import {
  createLead,
  listLeads,
  getLeadById,
  updateLeadStatus,
  assignLead,
  getLeadJourney,
} from './lead.controller';

const router = Router();

// All routes are admin-protected
router.post('/', authMiddleware, adminGuard, validate(createLeadSchema), createLead);
router.get('/', authMiddleware, adminGuard, listLeads);
router.get('/:id', authMiddleware, adminGuard, getLeadById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateStatusSchema), updateLeadStatus);
router.patch('/:id/assign', authMiddleware, adminGuard, validate(assignLeadSchema), assignLead);
router.get('/:id/journey', authMiddleware, adminGuard, getLeadJourney);

export default router;
