import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { validate } from '../../middleware/validate.middleware';
import { createConditionSchema, updateConditionSchema, sortingSchema, createSubConditionSchema, updateSubConditionSchema } from './skincondition.schema';
import {
  publicConditions,
  getConditionBySlug,
  listConditions,
  createCondition,
  updateCondition,
  deleteCondition,
  toggleConditionStatus,
  updateSorting,
  listSubConditions,
  createSubCondition,
  updateSubCondition,
  deleteSubCondition,
} from './skincondition.controller';

const router = Router();

// Public - literal paths first so they aren't swallowed by admin routes or the /:slug wildcard below.
router.get('/public', publicConditions);

// Main conditions
// GET / is intentionally not auth-gated - listConditions itself checks for a
// valid admin token and returns the full unfiltered list when present, or
// the same safe/active-only tree as GET /public otherwise. This keeps this
// exact URL usable by both the admin panel and the public frontend.
router.get('/', listConditions);
router.post('/', authMiddleware, adminGuard, validate(createConditionSchema), createCondition);
router.put('/:id', authMiddleware, adminGuard, validate(updateConditionSchema), updateCondition);
router.delete('/:id', authMiddleware, adminGuard, deleteCondition);
router.patch('/:id/toggle-status', authMiddleware, adminGuard, toggleConditionStatus);
router.patch('/sorting', authMiddleware, adminGuard, validate(sortingSchema), updateSorting);

// Sub-conditions
router.get('/sub', authMiddleware, adminGuard, listSubConditions);
router.post('/sub', authMiddleware, adminGuard, validate(createSubConditionSchema), createSubCondition);
router.patch('/sub/sorting', authMiddleware, adminGuard, validate(sortingSchema), updateSorting);
router.put('/sub/:id', authMiddleware, adminGuard, validate(updateSubConditionSchema), updateSubCondition);
router.delete('/sub/:id', authMiddleware, adminGuard, deleteSubCondition);

// Public - registered last so it doesn't swallow the literal paths above.
router.get('/:slug', getConditionBySlug);

export default router;
