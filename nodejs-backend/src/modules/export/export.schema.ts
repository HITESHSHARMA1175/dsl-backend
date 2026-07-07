import { z } from 'zod';

export const exportFilterSchema = z.object({
  status: z.string().optional(),
  source: z.string().optional(),
  start_date: z.string().optional(),
  end_date: z.string().optional(),
});
