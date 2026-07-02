import { z } from 'zod';

export const addToCartSchema = z.object({
  product_id: z.number().int().positive('Product ID is required'),
  product_name: z.string().min(1, 'Product name is required'),
  price: z.number().nonnegative().optional(),
  qty: z.number().int().positive().optional(),
  image: z.string().optional(),
  type: z.string().optional(),
  session: z.string().optional(),
});

export const updateQtySchema = z.object({
  qty: z.number().int(),
});

export const checkoutSchema = z.object({
  first_name: z.string().min(1, 'First name is required'),
  last_name: z.string().optional(),
  email: z.string().email('A valid email is required'),
  phone: z.string().min(1, 'Phone is required'),
  address: z.string().optional(),
  city: z.string().optional(),
  postcode: z.string().optional(),
  country: z.string().optional(),
  payment_method: z.string().optional(),
  user_id: z.number().int().optional(),
  session: z.string().optional(),
});
