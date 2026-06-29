import { z } from 'zod';

export const createServiceSchema = z.object({
  property_name: z.string().min(1, 'property_name is required'),
  description: z.string().optional(),
  long_description: z.string().optional(),
  price: z.number().min(0).optional(),
  discounted_price: z.number().min(0).optional(),
  number_of_members_required: z.number().int().min(1).optional(),
  duration: z.number().int().min(0).optional(),
  sessions: z.number().int().min(0).optional(),
  property_category: z.number().int().optional(),
  property_sub_category: z.number().int().optional(),
  parent_id: z.number().int().optional(),
  profile: z.string().optional(),
  status: z.string().optional(),
});

export const updateServiceSchema = z.object({
  property_name: z.string().min(1).optional(),
  description: z.string().optional(),
  long_description: z.string().optional(),
  price: z.number().min(0).optional(),
  discounted_price: z.number().min(0).optional(),
  number_of_members_required: z.number().int().min(1).optional(),
  duration: z.number().int().min(0).optional(),
  sessions: z.number().int().min(0).optional(),
  property_category: z.number().int().optional(),
  property_sub_category: z.number().int().optional(),
  parent_id: z.number().int().optional(),
  profile: z.string().optional(),
  status: z.string().optional(),
});
