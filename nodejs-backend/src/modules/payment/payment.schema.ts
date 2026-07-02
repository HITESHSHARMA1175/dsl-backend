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

export const checkoutSessionShopSchema = z.object({
  amount: z.number().positive(),
  billing_first_name: z.string().optional(),
  billing_last_name: z.string().optional(),
  billing_email: z.string().email(),
  billing_phone: z.string().optional(),
  billing_company: z.string().optional(),
  billing_address_1: z.string().optional(),
  billing_city: z.string().optional(),
  billing_postcode: z.string().optional(),
  billing_country: z.string().optional(),
});

export const confirmOrderSchema = z.object({
  session_id: z.string().min(1),
  cart_details: z.any().optional(),
});

export const processPaymentSchema = z.object({
  amount: z.number().positive(),
  payment_method_id: z.string().min(1),
  order_amount: z.number().optional(),
  payment_method: z.string().optional(),
  billing_first_name: z.string().optional(),
  billing_last_name: z.string().optional(),
  billing_email: z.string().email().optional(),
  billing_phone: z.string().optional(),
  billing_company: z.string().optional(),
  billing_address_1: z.string().optional(),
  billing_city: z.string().optional(),
  billing_postcode: z.string().optional(),
  billing_country: z.string().optional(),
  cart_details: z.any().optional(),
});

export const bookingPaymentSchema = z.object({
  amount: z.number().positive(),
  payment_method_id: z.string().min(1),
  payment_method: z.string().optional(),
  service_id: z.any().optional(),
  addon_id: z.any().optional(),
  profession_id: z.number().int().optional(),
  total_service_duration: z.union([z.number(), z.string()]).optional(),
  total_addon_duration: z.union([z.number(), z.string()]).optional(),
  ddate: z.string().optional(),
  slot_id: z.number().int().optional(),
  slot_date: z.string().optional(),
  slot_time: z.string().optional(),
  first_name: z.string().optional(),
  last_name: z.string().optional(),
  email: z.string().email().optional(),
  mobile: z.string().optional(),
  cart_details: z.any().optional(),
});

export const confirmBookingSchema = z.object({
  session_id: z.string().min(1),
  service_id: z.any().optional(),
  addon_id: z.any().optional(),
  profession_id: z.number().int().optional(),
  total_service_duration: z.union([z.number(), z.string()]).optional(),
  total_addon_duration: z.union([z.number(), z.string()]).optional(),
  ddate: z.string().optional(),
  slot_id: z.number().int().optional(),
  slot_date: z.string().optional(),
  slot_time: z.string().optional(),
  first_name: z.string().optional(),
  last_name: z.string().optional(),
  email: z.string().email().optional(),
  mobile: z.string().optional(),
  cart_details: z.any().optional(),
});

export const applePaySchema = z.object({
  amount: z.number().positive(),
  payment_method_id: z.string().min(1),
});

export const klarnaOrderWebSchema = z.object({
  authorization_token: z.string().min(1),
  order_amount: z.number().positive(),
  order_lines: z.array(z.any()).optional(),
  cart_details: z.any().optional(),
});
