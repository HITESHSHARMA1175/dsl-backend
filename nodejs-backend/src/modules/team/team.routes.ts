import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createTeamSchema, updateTeamSchema } from './team.schema';
import {
  listTeams,
  createTeam,
  updateTeam,
  deleteTeam,
  toggleTeamStatus,
} from './team.controller';

const router = Router();

// Public listing
router.get('/', listTeams);

// Admin protected
router.post('/', authMiddleware, adminGuard, validate(createTeamSchema), createTeam);
router.put('/:id', authMiddleware, adminGuard, validate(updateTeamSchema), updateTeam);
router.delete('/:id', authMiddleware, adminGuard, deleteTeam);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleTeamStatus);

export default router;
