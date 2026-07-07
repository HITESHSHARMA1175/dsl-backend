import { z } from 'zod';

export const createProfessionalSchema = z.object({
  professional_name: z.string().min(1, 'professional_name is required'),
  designation: z.string().optional(),
  profession: z.string().optional(),
  work_category: z.string().optional(),
  profile: z.string().optional(),
});

export const updateProfessionalSchema = z.object({
  professional_name: z.string().min(1).optional(),
  designation: z.string().optional(),
  profession: z.string().optional(),
  work_category: z.string().optional(),
  profile: z.string().optional(),
});
