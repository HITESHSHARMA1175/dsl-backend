import { z } from 'zod';

export const createSubscribeSchema = z.object({
  full_name: z.string().optional(),
  email: z.string().email('A valid email is required'),
  selectedTreatments: z.any().optional(),
});
