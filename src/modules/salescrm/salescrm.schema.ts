import { z } from 'zod';

export const createSalesLeadSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  source: z.string().optional(),
  notes: z.string().optional(),
});

export const updateStatusSchema = z.object({
  status: z.string().min(1, 'Status is required'),
  notes: z.string().optional(),
});

export const assignLeadSchema = z.object({
  empId: z.number().int().positive('Employee ID is required'),
});
