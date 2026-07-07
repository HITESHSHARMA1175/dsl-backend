import { z } from 'zod';

export const createClinicSchema = z.object({
  name: z.string().min(1, 'name is required'),
  address: z.string().optional(),
  phone: z.string().optional(),
  email: z.string().email('Invalid email format').optional(),
  website: z.string().optional(),
  whatsapp: z.string().optional(),
});

export const updateClinicSchema = z.object({
  name: z.string().min(1).optional(),
  address: z.string().optional(),
  phone: z.string().optional(),
  email: z.string().email('Invalid email format').optional(),
  website: z.string().optional(),
  whatsapp: z.string().optional(),
});
