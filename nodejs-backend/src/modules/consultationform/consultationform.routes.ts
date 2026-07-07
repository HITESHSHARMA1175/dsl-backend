import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  listConsultationForms,
  getConsultationFormById,
  getReferrals,
  getSubscribed,
  submitConsultationForm,
} from './consultationform.controller';

const router = Router();

// Public — submit a consultation/contact form
router.post('/', submitConsultationForm);

// Admin
router.get('/', authMiddleware, adminGuard, listConsultationForms);
router.get('/referrals', authMiddleware, adminGuard, getReferrals);
router.get('/subscribed', authMiddleware, adminGuard, getSubscribed);
router.get('/:id', authMiddleware, adminGuard, getConsultationFormById);

export default router;
