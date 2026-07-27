import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { createClinicSchema, updateClinicSchema } from './clinic.schema';
import {
  getPublicClinics,
  getPublicClinicBySlugOrId,
  listClinics,
  getClinicById,
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

// ----- Public locations endpoints (for Navbar / Website Locations page) -----
router.get('/public', getPublicClinics);
router.get('/public/:slugOrId', getPublicClinicBySlugOrId);

// ----- Mobile (clinic detail) endpoints — auth required -----
router.get('/rooms', authMiddleware, getClinicRooms);
router.get('/equipments', authMiddleware, getClinicEquipments);
router.get('/finance', authMiddleware, getClinicFinance);
router.get('/:id/info', authMiddleware, getClinicInfo);
router.get('/:id/hxg', authMiddleware, getClinicHxg);
router.get('/:id/time', authMiddleware, getClinicTime);

// ----- Admin CRUD -----
router.get('/', listClinics);
router.get('/:id', getClinicById);
router.post('/', authMiddleware, adminGuard, validate(createClinicSchema), createClinic);
router.put('/:id', authMiddleware, adminGuard, validate(updateClinicSchema), updateClinic);
router.delete('/:id', authMiddleware, adminGuard, deleteClinic);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleClinicStatus);

export default router;
