import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createEmployeeSchema, updateEmployeeSchema } from './employee.schema';
import {
  listEmployees,
  createEmployee,
  updateEmployee,
  getEmployeeById,
  toggleEmployeeStatus,
  getEmployeeMap,
} from './employee.controller';

const router = Router();

router.get('/', authMiddleware, adminGuard, listEmployees);
router.post('/', authMiddleware, adminGuard, validate(createEmployeeSchema), createEmployee);
router.put('/:id', authMiddleware, adminGuard, validate(updateEmployeeSchema), updateEmployee);
router.get('/:id', authMiddleware, adminGuard, getEmployeeById);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleEmployeeStatus);
router.get('/:id/map', authMiddleware, adminGuard, getEmployeeMap);

export default router;
