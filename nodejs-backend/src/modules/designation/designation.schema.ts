import { z } from 'zod';

export const createDesignationSchema = z.object({
  name: z.string().min(1, 'name is required'),
  status: z.number().int().optional(),
});

export const updateDesignationSchema = z.object({
  name: z.string().min(1).optional(),
  status: z.number().int().optional(),
});
