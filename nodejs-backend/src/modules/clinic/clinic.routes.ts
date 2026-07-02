import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createClinicSchema, updateClinicSchema } from './clinic.schema';
import {
  listClinics,
  createClinic,
  updateClinic,
  deleteClinic,
  toggleClinicStatus,
  getClinicInfo,
  getClinicHxg,
  getClinicTime,
  getClinicRooms,
  getClinicEquipments,
  getClinicFinance,
} from './clinic.controller';

const router = Router();

// ----- Mobile (clinic detail) endpoints — auth required -----
router.get('/rooms', authMiddleware, getClinicRooms);
router.get('/equipments', authMiddleware, getClinicEquipments);
router.get('/finance', authMiddleware, getClinicFinance);
router.get('/:id/info', authMiddleware, getClinicInfo);
router.get('/:id/hxg', authMiddleware, getClinicHxg);
router.get('/:id/time', authMiddleware, getClinicTime);

// ----- Admin CRUD -----
router.get('/', authMiddleware, adminGuard, listClinics);
router.post('/', authMiddleware, adminGuard, validate(createClinicSchema), createClinic);
router.put('/:id', authMiddleware, adminGuard, validate(updateClinicSchema), updateClinic);
router.delete('/:id', authMiddleware, adminGuard, deleteClinic);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleClinicStatus);

export default router;
