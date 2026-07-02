import { z } from 'zod';

export const createLeadSchema = z.object({
  name: z.string().min(1, 'name is required'),
  mobile_no: z.string().min(1, 'mobile_no is required'),
  email: z.string().email('email must be a valid email address').optional(),
  source: z.string().optional(),
  message: z.string().optional(),
  assign_emp: z.string().optional(),
  campaigns: z.string().optional(),
});

export const updateStatusSchema = z.object({
  status: z.string().min(1, 'status is required'),
  notes: z.string().optional(),
});

export const assignLeadSchema = z.object({
  assign_emp: z.string().min(1, 'assign_emp is required'),
});
