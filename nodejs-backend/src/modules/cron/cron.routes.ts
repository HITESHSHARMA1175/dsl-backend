import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createMoveinPayment, sendBirthdayEmails } from './cron.controller';

const router = Router();

router.post('/create-movein-payment', authMiddleware, adminGuard, createMoveinPayment);
router.post('/send-birthday-emails', authMiddleware, adminGuard, sendBirthdayEmails);

export default router;
