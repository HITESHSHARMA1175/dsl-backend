import { Router } from 'express';
import { validate } from '../../middleware/validate.middleware';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  createBrandSchema, updateBrandSchema,
  createModelSchema, updateModelSchema,
  createVariantSchema, updateVariantSchema,
  createColourSchema, updateColourSchema,
} from './mobile.schema';
import {
  listBrands, createBrand, updateBrand, deleteBrand,
  listModels, createModel, updateModel, deleteModel,
  listVariants, createVariant, updateVariant, deleteVariant,
  listColours, createColour, updateColour, deleteColour,
} from './mobile.controller';

const router = Router();

// Brands
router.get('/brands', authMiddleware, adminGuard, listBrands);
router.post('/brands', authMiddleware, adminGuard, validate(createBrandSchema), createBrand);
router.put('/brands/:id', authMiddleware, adminGuard, validate(updateBrandSchema), updateBrand);
router.delete('/brands/:id', authMiddleware, adminGuard, deleteBrand);

// Models
router.get('/models', authMiddleware, adminGuard, listModels);
router.post('/models', authMiddleware, adminGuard, validate(createModelSchema), createModel);
router.put('/models/:id', authMiddleware, adminGuard, validate(updateModelSchema), updateModel);
router.delete('/models/:id', authMiddleware, adminGuard, deleteModel);

// Variants
router.get('/variants', authMiddleware, adminGuard, listVariants);
router.post('/variants', authMiddleware, adminGuard, validate(createVariantSchema), createVariant);
router.put('/variants/:id', authMiddleware, adminGuard, validate(updateVariantSchema), updateVariant);
router.delete('/variants/:id', authMiddleware, adminGuard, deleteVariant);

// Colours
router.get('/colours', authMiddleware, adminGuard, listColours);
router.post('/colours', authMiddleware, adminGuard, validate(createColourSchema), createColour);
router.put('/colours/:id', authMiddleware, adminGuard, validate(updateColourSchema), updateColour);
router.delete('/colours/:id', authMiddleware, adminGuard, deleteColour);

export default router;
