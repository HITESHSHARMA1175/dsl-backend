import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { getHomePage } from './home.controller';

const router = Router();

router.get('/', authMiddleware, getHomePage);

export default router;
