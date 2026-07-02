import { z } from 'zod';

// Consultation forms are read-only in admin, so no create/update schemas needed
// Keeping schema file for consistency

export const consultationFormQuerySchema = z.object({
  page: z.string().optional(),
  perPage: z.string().optional(),
});
