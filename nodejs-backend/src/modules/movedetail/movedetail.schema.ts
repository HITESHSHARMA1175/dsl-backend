import { z } from 'zod';

export const createMoveDetailSchema = z.object({
  property_id: z.number().int(),
  tenant_id: z.number().int().optional(),
  move_in_date: z.string().optional(),
  move_out_date: z.string().optional(),
  rent_amount: z.number().optional(),
  deposit_amount: z.number().optional(),
  notes: z.string().optional(),
});

export const updateMoveDetailSchema = z.object({
  property_id: z.number().int().optional(),
  tenant_id: z.number().int().optional(),
  move_in_date: z.string().optional(),
  move_out_date: z.string().optional(),
  rent_amount: z.number().optional(),
  deposit_amount: z.number().optional(),
  notes: z.string().optional(),
});
