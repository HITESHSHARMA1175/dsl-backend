import { z } from 'zod';

export const createSellerSchema = z.object({
  first_name: z.string().min(1, 'First name is required'),
  last_name: z.string().optional(),
  email: z.string().email('A valid email is required'),
  mobile_no: z.string().optional(),
  password: z.string().min(6, 'Password must be at least 6 characters'),
  shop_name: z.string().optional(),
  shop_gst: z.string().optional(),
  shop_pan: z.string().optional(),
  address: z.string().optional(),
});

export const updateSellerSchema = z.object({
  first_name: z.string().min(1).optional(),
  last_name: z.string().optional(),
  mobile_no: z.string().optional(),
  password: z.string().min(6).optional(),
  shop_name: z.string().optional(),
  shop_gst: z.string().optional(),
  shop_pan: z.string().optional(),
  address: z.string().optional(),
});
