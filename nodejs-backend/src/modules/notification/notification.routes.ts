import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { sendNotificationSchema } from './notification.schema';
import { sendNotification } from './notification.controller';

const router = Router();

router.post('/send', authMiddleware, adminGuard, validate(sendNotificationSchema), sendNotification);

export default router;
