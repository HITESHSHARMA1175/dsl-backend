import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import {
  createDataSchema,
  updateDataSchema,
  updateDataStatusSchema,
  assignDataSchema,
} from './datacrm.schema';
import {
  listData,
  getDataById,
  createData,
  updateData,
  updateDataStatus,
  assignData,
  markDataDead,
  getDataJourney,
  getDataImportLogs,
  getDataImportErrors,
} from './datacrm.controller';

const router = Router();

// All routes are admin-protected
router.get('/', authMiddleware, adminGuard, listData);
router.get('/import-logs', authMiddleware, adminGuard, getDataImportLogs);
router.get('/import-logs/:id/errors', authMiddleware, adminGuard, getDataImportErrors);
router.post('/', authMiddleware, adminGuard, validate(createDataSchema), createData);
router.get('/:id', authMiddleware, adminGuard, getDataById);
router.put('/:id', authMiddleware, adminGuard, validate(updateDataSchema), updateData);
router.patch('/:id/status', authMiddleware, adminGuard, validate(updateDataStatusSchema), updateDataStatus);
router.patch('/:id/assign', authMiddleware, adminGuard, validate(assignDataSchema), assignData);
router.patch('/:id/dead', authMiddleware, adminGuard, markDataDead);
router.get('/:id/journey', authMiddleware, adminGuard, getDataJourney);

export default router;
