import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createPatientSchema, updatePatientSchema, saveMedicalHistorySchema } from './patient.schema';
import {
  createPatient,
  updatePatient,
  listPatients,
  getPatientById,
  getPatientTimeline,
  saveMedicalHistory,
  getMedicalHistory,
  getPatientFinance,
} from './patient.controller';

const router = Router();

// All routes are auth-protected
router.post('/', authMiddleware, validate(createPatientSchema), createPatient);
router.put('/:id', authMiddleware, validate(updatePatientSchema), updatePatient);
router.get('/', authMiddleware, listPatients);
router.get('/:id', authMiddleware, getPatientById);
router.get('/:id/timeline', authMiddleware, getPatientTimeline);
router.get('/:id/finance', authMiddleware, getPatientFinance);
router.post('/:id/medical-history', authMiddleware, validate(saveMedicalHistorySchema), saveMedicalHistory);
router.get('/:id/medical-history', authMiddleware, getMedicalHistory);

export default router;
