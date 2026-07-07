import { z } from 'zod';

export const createSellerLeadSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  source: z.string().optional(),
  notes: z.string().optional(),
});

export const updateSellerStatusSchema = z.object({
  status: z.string().min(1, 'Status is required'),
  notes: z.string().optional(),
});
