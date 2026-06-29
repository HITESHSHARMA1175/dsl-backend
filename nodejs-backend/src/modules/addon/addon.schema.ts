import { z } from 'zod';

export const createAddonSchema = z.object({
  addon_name: z.string().min(1, 'addon_name is required'),
  parent_id: z.number().int().optional(),
  description: z.string().optional(),
  long_description: z.string().optional(),
  price: z.number().optional(),
  discounted_price: z.number().optional(),
  number_of_members_required: z.number().int().optional(),
  duration: z.number().int().optional(),
  profile: z.string().optional(),
  status: z.string().optional(),
});

export const updateAddonSchema = z.object({
  addon_name: z.string().min(1).optional(),
  parent_id: z.number().int().optional(),
  description: z.string().optional(),
  long_description: z.string().optional(),
  price: z.number().optional(),
  discounted_price: z.number().optional(),
  number_of_members_required: z.number().int().optional(),
  duration: z.number().int().optional(),
  profile: z.string().optional(),
  status: z.string().optional(),
});
