import { z } from 'zod';

export const masterValuesQuerySchema = z.object({
  MasterHead: z.coerce.number().int().min(1, 'MasterHead is required'),
});
