import { z } from 'zod';

export const createAttributeSchema = z.object({
  name: z.string().min(1, 'name is required'),
  type: z.string().optional(),
  is_required: z.number().int().optional(),
});

export const updateAttributeSchema = z.object({
  name: z.string().min(1).optional(),
  type: z.string().optional(),
  is_required: z.number().int().optional(),
});

export const createAttributeValueSchema = z.object({
  attribute_id: z.number().int(),
  value: z.string().min(1, 'value is required'),
});

export const updateAttributeValueSchema = z.object({
  value: z.string().min(1).optional(),
});

export const mapCategorySchema = z.object({
  category_id: z.number().int(),
  attribute_ids: z.array(z.number().int()),
});
