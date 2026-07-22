import { z } from 'zod';

export const createShopProductSchema = z.object({
  name: z.string().min(1, 'Product name is required'),
  description: z.string().nullable().optional(),
  price: z.number().nonnegative().optional(),
  image: z.string().nullable().optional(),
  category: z.string().nullable().optional(),
  type: z.enum(['custom', 'shopify']).optional().default('custom'),
  shopify_url: z.union([z.null(), z.literal(''), z.string().url('Must be a valid URL')]).optional(),
  is_active: z.number().int().optional(),
  sort_order: z.number().int().optional(),
}).strip();

export const updateShopProductSchema = createShopProductSchema.partial();
