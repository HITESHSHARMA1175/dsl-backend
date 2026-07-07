import { z } from 'zod';

export const createRedUrlSchema = z.object({
  old_url: z.string().min(1, 'Old URL is required'),
  redirect_url: z.string().min(1, 'Redirect URL is required'),
});

export const updateRedUrlSchema = z.object({
  old_url: z.string().min(1).optional(),
  redirect_url: z.string().min(1).optional(),
});
