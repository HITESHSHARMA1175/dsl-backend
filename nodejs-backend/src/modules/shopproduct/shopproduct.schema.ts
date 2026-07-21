import { z } from 'zod';

export const createShopProductSchema = z.object({
  name: z.string().min(1, 'Product name is required'),
  description: z.string().optional(),
  price: z.number().nonnegative().optional(),
  image: z.string().optional(),
  category: z.string().optional(),
  type: z.enum(['custom', 'shopify']).optional().default('custom'),
  shopify_url: z.string().url('Must be a valid URL').optional().or(z.literal('')),
  is_active: z.number().int().optional(),
  sort_order: z.number().int().optional(),
});

export const updateShopProductSchema = createShopProductSchema.partial();
