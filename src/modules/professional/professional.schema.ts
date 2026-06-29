import { z } from 'zod';

export const createProfessionalSchema = z.object({
  professional_name: z.string().min(1, 'professional_name is required'),
  designation: z.string().optional(),
  profession: z.string().optional(),
  parent_id: z.number().int().optional(),
  category_ids: z.string().optional(),
  profile: z.string().optional(),
  rating: z.number().min(0).max(5).optional(),
});

export const updateProfessionalSchema = z.object({
  professional_name: z.string().min(1).optional(),
  designation: z.string().optional(),
  profession: z.string().optional(),
  parent_id: z.number().int().optional(),
  category_ids: z.string().optional(),
  profile: z.string().optional(),
  rating: z.number().min(0).max(5).optional(),
});
