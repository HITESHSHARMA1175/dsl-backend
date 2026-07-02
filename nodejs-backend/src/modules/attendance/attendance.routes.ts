import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { markAttendanceSchema, punchOutSchema, addLeaveSchema } from './attendance.schema';
import {
  markAttendance,
  punchOut,
  getMyAttendance,
  getAllAttendance,
  addLeave,
  getMyLeaves,
} from './attendance.controller';

const router = Router();

// All routes are auth-protected
router.post('/punch-in', authMiddleware, validate(markAttendanceSchema), markAttendance);
router.patch('/:id/punch-out', authMiddleware, validate(punchOutSchema), punchOut);
router.get('/my', authMiddleware, getMyAttendance);
router.post('/leave', authMiddleware, validate(addLeaveSchema), addLeave);
router.get('/leave/my', authMiddleware, getMyLeaves);
router.get('/', authMiddleware, adminGuard, getAllAttendance);

export default router;
