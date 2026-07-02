import { z } from 'zod';

export const createServicecatSchema = z.object({
  category_name: z.string().min(1, 'Category name is required'),
  parent_id: z.number().int().nonnegative().optional(),
  category_slug: z.string().optional(),
  description: z.string().optional(),
  meta_title: z.string().optional(),
  meta_keywords: z.string().optional(),
  meta_description: z.string().optional(),
  icon: z.string().optional(),
  banner: z.string().optional(),
});

export const updateServicecatSchema = z.object({
  category_name: z.string().min(1).optional(),
  parent_id: z.number().int().nonnegative().optional(),
  category_slug: z.string().optional(),
  description: z.string().optional(),
  meta_title: z.string().optional(),
  meta_keywords: z.string().optional(),
  meta_description: z.string().optional(),
  icon: z.string().optional(),
  banner: z.string().optional(),
});

export const sortingSchema = z.object({
  items: z
    .array(
      z.object({
        id: z.number().int().positive(),
        sorting_order: z.number().int(),
      })
    )
    .min(1, 'At least one item is required'),
});
