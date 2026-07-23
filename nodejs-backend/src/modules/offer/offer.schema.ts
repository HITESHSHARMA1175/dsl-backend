import { z } from 'zod';

export const createOfferSchema = z.object({
  title: z.string().min(1, 'Title is required'),
  subtitle: z.string().optional().nullable(),
  category: z.string().optional().nullable(),
  badges: z.union([z.array(z.string()), z.string()]).optional().nullable(),
  price: z.number().min(0, 'Price must be non-negative'),
  was_price: z.number().optional().nullable(),
  description: z.string().optional().nullable(),
  button_text: z.string().optional().nullable(),
  button_link: z.string().optional().nullable(),
  image: z.string().optional().nullable(),
  is_featured: z.number().int().optional().default(0),
  featured_price_unit: z.string().optional().nullable(),
  featured_subtitle: z.string().optional().nullable(),
  is_active: z.number().int().optional().default(1),
  sort_order: z.number().int().optional().default(0),
});

export const updateOfferSchema = createOfferSchema.partial();
