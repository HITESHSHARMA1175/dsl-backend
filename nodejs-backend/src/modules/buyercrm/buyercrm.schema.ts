import { z } from 'zod';

export const createBuyerLeadSchema = z.object({
  name: z.string().min(1, 'name is required'),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  source: z.string().optional(),
  notes: z.string().optional(),
});

export const updateBuyerLeadStatusSchema = z.object({
  status: z.string().min(1, 'status is required'),
  notes: z.string().optional(),
});
