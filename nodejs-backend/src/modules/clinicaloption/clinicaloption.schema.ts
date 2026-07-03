import { z } from 'zod';

export const createClinicalOptionSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  parent_id: z.number().int().optional(),
});

export const updateClinicalOptionSchema = z.object({
  name: z.string().min(1).optional(),
  parent_id: z.number().int().optional(),
});
