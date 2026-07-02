import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  createAttributeSchema,
  updateAttributeSchema,
  createAttributeValueSchema,
  updateAttributeValueSchema,
  mapCategorySchema,
} from './attribute.schema';
import {
  listAttributes,
  createAttribute,
  updateAttribute,
  deleteAttribute,
  listValues,
  createValue,
  updateValue,
  deleteValue,
  mapToCategory,
} from './attribute.controller';

const router = Router();

// Attributes
router.get('/', authMiddleware, adminGuard, listAttributes);
router.post('/', authMiddleware, adminGuard, validate(createAttributeSchema), createAttribute);
router.put('/:id', authMiddleware, adminGuard, validate(updateAttributeSchema), updateAttribute);
router.delete('/:id', authMiddleware, adminGuard, deleteAttribute);

// Attribute Values
router.get('/values', authMiddleware, adminGuard, listValues);
router.post('/values', authMiddleware, adminGuard, validate(createAttributeValueSchema), createValue);
router.put('/values/:id', authMiddleware, adminGuard, validate(updateAttributeValueSchema), updateValue);
router.delete('/values/:id', authMiddleware, adminGuard, deleteValue);

// Map to category
router.post('/map-category', authMiddleware, adminGuard, validate(mapCategorySchema), mapToCategory);

export default router;
