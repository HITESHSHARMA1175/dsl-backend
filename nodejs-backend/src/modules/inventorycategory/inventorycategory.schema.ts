import { z } from 'zod';

export const createInventoryCategorySchema = z.object({
  name: z.string().min(1, 'name is required'),
  parent_id: z.number().int().optional(),
  status: z.number().int().optional(),
});

export const updateInventoryCategorySchema = z.object({
  name: z.string().min(1).optional(),
  parent_id: z.number().int().optional(),
  status: z.number().int().optional(),
});
