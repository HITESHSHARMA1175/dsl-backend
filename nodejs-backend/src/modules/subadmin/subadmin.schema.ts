import { z } from 'zod';

export const createSubadminSchema = z.object({
  first_name: z.string().min(1, 'First name is required'),
  last_name: z.string().optional(),
  email: z.string().email('A valid email is required'),
  mobile_no: z.string().optional(),
  password: z.string().min(6, 'Password must be at least 6 characters'),
  menu_permission: z.string().optional(),
  designation: z.number().int().optional(),
});

export const updateSubadminSchema = z.object({
  first_name: z.string().min(1).optional(),
  last_name: z.string().optional(),
  mobile_no: z.string().optional(),
  password: z.string().min(6).optional(),
  menu_permission: z.string().optional(),
  designation: z.number().int().optional(),
});
