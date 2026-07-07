import { z } from 'zod';

export const createConditionSchema = z.object({
  category_name: z.string().min(1, 'Name is required'),
  description: z.string().optional(),
  image: z.string().optional(),
});

export const updateConditionSchema = z.object({
  category_name: z.string().min(1).optional(),
  description: z.string().optional(),
  image: z.string().optional(),
});

export const sortingSchema = z.object({
  items: z.array(
    z.object({
      id: z.number().int().positive(),
      sorting: z.number().int(),
    })
  ).min(1),
});

export const createSubConditionSchema = z.object({
  category_name: z.string().min(1, 'Name is required'),
  parent_id: z.number().int().positive('Parent ID is required'),
  description: z.string().optional(),
  image: z.string().optional(),
});

export const updateSubConditionSchema = z.object({
  category_name: z.string().min(1).optional(),
  parent_id: z.number().int().positive().optional(),
  description: z.string().optional(),
  image: z.string().optional(),
});
