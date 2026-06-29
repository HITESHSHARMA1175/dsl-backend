import { z } from 'zod';

export const createPaymentIntentSchema = z.object({
  amount: z.number().positive(),
  payment_method_id: z.string().min(1),
});

export const createCheckoutSessionSchema = z.object({
  amount: z.number().positive(),
  success_url: z.string().url().optional(),
  cancel_url: z.string().url().optional(),
});

export const createKlarnaSessionSchema = z.object({
  order_lines: z.array(z.any()),
});

export const createKlarnaOrderSchema = z.object({
  authorization_token: z.string().min(1),
  order_data: z.any(),
});
