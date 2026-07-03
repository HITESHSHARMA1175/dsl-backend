import { z } from 'zod';

// Banner schemas
export const createBannerSchema = z.object({
  title: z.string().min(1, 'title is required'),
  image: z.string().optional(),
  link: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

export const updateBannerSchema = z.object({
  title: z.string().min(1).optional(),
  image: z.string().optional(),
  link: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

// Review schemas
export const createReviewSchema = z.object({
  name: z.string().min(1, 'name is required'),
  rating: z.number().int().min(1).max(5),
  review: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

export const updateReviewSchema = z.object({
  name: z.string().min(1).optional(),
  rating: z.number().int().min(1).max(5).optional(),
  review: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

// FAQ schemas
export const createFaqSchema = z.object({
  category_id: z.number().int(),
  question: z.string().min(1, 'question is required'),
  answer: z.string().optional(),
  sorting_order: z.number().int().min(0).optional(),
  status: z.coerce.number().int().optional(),
});

export const updateFaqSchema = z.object({
  category_id: z.number().int().optional(),
  question: z.string().min(1).optional(),
  answer: z.string().optional(),
  sorting_order: z.number().int().min(0).optional(),
  status: z.coerce.number().int().optional(),
});

export const updateFaqSortingSchema = z.object({
  items: z.array(
    z.object({
      id: z.number().int(),
      sorting_order: z.number().int().min(0),
    })
  ).min(1, 'items array is required'),
});

// Blog schemas
export const createBlogSchema = z.object({
  title: z.string().min(1, 'title is required'),
  slug: z.string().optional(),
  content: z.string().optional(),
  blog_category: z.number().int().optional(),
  image: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

export const updateBlogSchema = z.object({
  title: z.string().min(1).optional(),
  slug: z.string().optional(),
  content: z.string().optional(),
  blog_category: z.number().int().optional(),
  image: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

// SEO schemas
export const createSeoSchema = z.object({
  page_name: z.string().min(1, 'page_name is required'),
  pageurl: z.string().optional(),
  meta_title: z.string().optional(),
  meta_description: z.string().optional(),
  meta_keywords: z.string().optional(),
  status: z.coerce.number().int().optional(),
});

export const updateSeoSchema = z.object({
  page_name: z.string().min(1).optional(),
  pageurl: z.string().optional(),
  meta_title: z.string().optional(),
  meta_description: z.string().optional(),
  meta_keywords: z.string().optional(),
  status: z.coerce.number().int().optional(),
});
