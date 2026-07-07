import { z } from 'zod';

export const reportFilterSchema = z.object({
  start_date: z.string().optional(),
  end_date: z.string().optional(),
  status: z.string().optional(),
});
