import { z } from 'zod';

export const getAvailableSlotsSchema = z.object({
  professional_id: z.coerce.number().int().positive(),
  date: z.string().min(1),
  total_service_duration: z.coerce.number().int().positive(),
});

export type GetAvailableSlotsInput = z.infer<typeof getAvailableSlotsSchema>;
