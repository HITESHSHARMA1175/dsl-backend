import { z } from 'zod';

export const createClinicalOptionSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  type: z.string().optional(),
  value: z.string().optional(),
});

export const updateClinicalOptionSchema = z.object({
  name: z.string().min(1).optional(),
  type: z.string().optional(),
  value: z.string().optional(),
});
