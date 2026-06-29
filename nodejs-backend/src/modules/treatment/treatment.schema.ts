import { z } from 'zod';

export const createTreatmentSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  treatment_type: z.number({ required_error: 'Treatment type is required' }),
});

export const updateTreatmentSchema = z.object({
  name: z.string().min(1).optional(),
  treatment_type: z.number().optional(),
  status: z.string().optional(),
});
