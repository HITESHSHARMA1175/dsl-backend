import { z } from 'zod';

export const createTenantSchema = z.object({
  name: z.string().min(1, 'name is required'),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  address: z.string().optional(),
  property_id: z.number().int().optional(),
  move_in_date: z.string().optional(),
});

export const updateTenantSchema = z.object({
  name: z.string().min(1).optional(),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  address: z.string().optional(),
  property_id: z.number().int().optional(),
  move_in_date: z.string().optional(),
});
