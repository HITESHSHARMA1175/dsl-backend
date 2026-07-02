import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createSubscribeSchema } from './subscribe.schema';
import { createSubscription, listSubscriptions } from './subscribe.controller';

const router = Router();

// Public — submit a subscription
router.post('/', validate(createSubscribeSchema), createSubscription);

// Admin — list subscriptions
router.get('/', authMiddleware, adminGuard, listSubscriptions);

export default router;
