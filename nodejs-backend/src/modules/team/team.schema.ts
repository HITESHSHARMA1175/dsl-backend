import { z } from 'zod';

export const createTeamSchema = z.object({
  name: z.string().min(1, 'Name is required'),
  designation: z.string().optional(),
  image: z.string().optional(),
  description: z.string().optional(),
});

export const updateTeamSchema = z.object({
  name: z.string().min(1).optional(),
  designation: z.string().optional(),
  image: z.string().optional(),
  description: z.string().optional(),
});
