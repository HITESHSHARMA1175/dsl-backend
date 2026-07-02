import { z } from 'zod';

export const createInventorySchema = z.object({
  name: z.string().min(1, 'Name is required'),
  category_id: z.number().int().optional(),
  quantity: z.number().int().optional(),
  unit: z.string().optional(),
  price: z.number().optional(),
  description: z.string().optional(),
});

export const updateInventorySchema = z.object({
  name: z.string().min(1).optional(),
  category_id: z.number().int().optional(),
  quantity: z.number().int().optional(),
  unit: z.string().optional(),
  price: z.number().optional(),
  description: z.string().optional(),
});

export const createInventoryCategorySchema = z.object({
  name: z.string().min(1, 'Category name is required'),
});
