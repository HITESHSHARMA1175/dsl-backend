import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import {
  createAppointmentSchema,
  addNotesSchema,
  addLogsSchema,
  updateAppointmentStatusSchema,
  rescheduleAppointmentSchema,
} from './appointment.schema';
import {
  createAppointment,
  listAppointments,
  getAppointmentById,
  addAppointmentNotes,
  addAppointmentLogs,
  updateAppointmentStatus,
  rescheduleAppointment,
  deleteAppointment,
} from './appointment.controller';

const router = Router();

// All routes are auth-protected
router.post('/', authMiddleware, validate(createAppointmentSchema), createAppointment);
router.get('/', authMiddleware, listAppointments);
router.get('/:id', authMiddleware, getAppointmentById);
router.patch('/:id/status', authMiddleware, validate(updateAppointmentStatusSchema), updateAppointmentStatus);
router.patch('/:id/reschedule', authMiddleware, validate(rescheduleAppointmentSchema), rescheduleAppointment);
router.post('/:id/notes', authMiddleware, validate(addNotesSchema), addAppointmentNotes);
router.post('/:id/logs', authMiddleware, validate(addLogsSchema), addAppointmentLogs);
router.delete('/:id', authMiddleware, deleteAppointment);

export default router;
