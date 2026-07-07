import { z } from 'zod';

export const createBuilderSchema = z.object({
  name: z.string().min(1, 'name is required'),
  contact_person: z.string().optional(),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  address: z.string().optional(),
});

export const updateBuilderSchema = z.object({
  name: z.string().min(1).optional(),
  contact_person: z.string().optional(),
  email: z.string().email().optional(),
  phone: z.string().optional(),
  address: z.string().optional(),
});
