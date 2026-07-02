import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createAppointmentSchema, addNotesSchema, addLogsSchema } from './appointment.schema';
import {
  createAppointment,
  listAppointments,
  getAppointmentById,
  addAppointmentNotes,
  addAppointmentLogs,
} from './appointment.controller';

const router = Router();

// All routes are auth-protected
router.post('/', authMiddleware, validate(createAppointmentSchema), createAppointment);
router.get('/', authMiddleware, listAppointments);
router.get('/:id', authMiddleware, getAppointmentById);
router.post('/:id/notes', authMiddleware, validate(addNotesSchema), addAppointmentNotes);
router.post('/:id/logs', authMiddleware, validate(addLogsSchema), addAppointmentLogs);

export default router;
