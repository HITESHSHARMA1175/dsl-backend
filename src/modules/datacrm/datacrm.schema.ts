import { z } from 'zod';

export const createDataSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  mobile_no: z.string().min(1, 'Mobile number is required'),
  email: z.string().email().optional().or(z.literal('')),
  alt_mobile_no: z.string().optional(),
  city: z.string().optional(),
  source: z.string().optional(),
  message: z.string().optional(),
  campaigns: z.string().optional(),
  property_id: z.number().int().optional(),
  builder_id: z.number().int().optional(),
  society_id: z.number().int().optional(),
  assign_emp: z.number().int().optional(),
});

export const updateDataSchema = z.object({
  name: z.string().min(1).optional(),
  mobile_no: z.string().optional(),
  email: z.string().email().optional().or(z.literal('')),
  alt_mobile_no: z.string().optional(),
  city: z.string().optional(),
  source: z.string().optional(),
  message: z.string().optional(),
  campaigns: z.string().optional(),
  property_id: z.number().int().optional(),
  builder_id: z.number().int().optional(),
  society_id: z.number().int().optional(),
});

export const updateDataStatusSchema = z.object({
  status: z.string().min(1, 'Status is required'),
  remark: z.string().optional(),
});

export const assignDataSchema = z.object({
  assign_emp: z.number().int().positive('Employee ID is required'),
});
