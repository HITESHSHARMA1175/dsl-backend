import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createSellerLeadSchema, updateSellerStatusSchema } from './sellercrm.schema';
import {
  listSellerLeads,
  createSellerLead,
  getSellerLeadById,
  updateSellerLeadStatus,
  getSellerLeadJourney,
  assignedSellerData,
  sellerDataDetails,
  sellerDataUpdate,
} from './sellercrm.controller';

const router = Router();

// ----- Mobile field-staff endpoints (any authenticated user) -----
router.get('/field/assigned', authMiddleware, assignedSellerData);
router.get('/field/details/:id', authMiddleware, sellerDataDetails);
router.put('/field/update/:id', authMiddleware, sellerDataUpdate);

// ----- Admin lead management -----
router.get('/', authMiddleware, adminGuard, listSellerLeads);
router.post('/', authMiddleware, adminGuard, validate(createSellerLeadSchema), createSellerLead);
router.get('/:id', authMiddleware, adminGuard, getSellerLeadById);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateSellerStatusSchema), updateSellerLeadStatus);
router.get('/:id/journey', authMiddleware, adminGuard, getSellerLeadJourney);

export default router;
