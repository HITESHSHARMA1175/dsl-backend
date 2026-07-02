import { z } from 'zod';

export const createOwnerSchema = z.object({
  name: z.string().min(1, 'name is required'),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  address: z.string().optional(),
  property_id: z.number().int().optional(),
});

export const updateOwnerSchema = z.object({
  name: z.string().min(1).optional(),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  address: z.string().optional(),
  property_id: z.number().int().optional(),
});
