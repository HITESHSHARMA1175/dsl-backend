import { z } from 'zod';

export const createMedicalHistorySchema = z.object({
  name: z.string().min(1, 'Name is required'),
  description: z.string().optional(),
});

export const updateMedicalHistorySchema = z.object({
  name: z.string().min(1).optional(),
  description: z.string().optional(),
});
