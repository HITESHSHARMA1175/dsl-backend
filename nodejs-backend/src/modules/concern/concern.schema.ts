import { z } from 'zod';

export const saveConcernsSchema = z.object({
  patientId: z.number().int().positive(),
  concernIds: z.array(z.number().int().positive()).min(1, 'At least one concern is required'),
});
