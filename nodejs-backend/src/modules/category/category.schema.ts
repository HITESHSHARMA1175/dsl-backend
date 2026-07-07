import { z } from 'zod';

export const createCategorySchema = z.object({
  category_name: z.string().min(1, 'category_name is required'),
  parent_id: z.number().int().optional(),
});

export const updateCategorySchema = z.object({
  category_name: z.string().min(1).optional(),
  parent_id: z.number().int().optional(),
});
