import { z } from 'zod';

export const createBrandSchema = z.object({
  name: z.string().min(1, 'name is required'),
  status: z.number().int().optional(),
});

export const updateBrandSchema = z.object({
  name: z.string().min(1).optional(),
  status: z.number().int().optional(),
});

export const createModelSchema = z.object({
  brand_id: z.number().int(),
  name: z.string().min(1, 'name is required'),
  status: z.number().int().optional(),
});

export const updateModelSchema = z.object({
  brand_id: z.number().int().optional(),
  name: z.string().min(1).optional(),
  status: z.number().int().optional(),
});

export const createVariantSchema = z.object({
  model_id: z.number().int(),
  name: z.string().min(1, 'name is required'),
  status: z.number().int().optional(),
});

export const updateVariantSchema = z.object({
  model_id: z.number().int().optional(),
  name: z.string().min(1).optional(),
  status: z.number().int().optional(),
});

export const createColourSchema = z.object({
  name: z.string().min(1, 'name is required'),
  code: z.string().optional(),
  status: z.number().int().optional(),
});

export const updateColourSchema = z.object({
  name: z.string().min(1).optional(),
  code: z.string().optional(),
  status: z.number().int().optional(),
});
