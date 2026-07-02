import { z } from 'zod';

export const createSocietySchema = z.object({
  name: z.string().min(1, 'name is required'),
  address: z.string().optional(),
  city: z.string().optional(),
  state: z.string().optional(),
  pincode: z.string().optional(),
  builder_id: z.number().int().optional(),
});

export const updateSocietySchema = z.object({
  name: z.string().min(1).optional(),
  address: z.string().optional(),
  city: z.string().optional(),
  state: z.string().optional(),
  pincode: z.string().optional(),
  builder_id: z.number().int().optional(),
});
