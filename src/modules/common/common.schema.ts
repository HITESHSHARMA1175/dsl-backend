import { z } from 'zod';

export const stateQuerySchema = z.object({
  country_id: z.string().optional(),
});

export const cityQuerySchema = z.object({
  state_id: z.string().optional(),
});
