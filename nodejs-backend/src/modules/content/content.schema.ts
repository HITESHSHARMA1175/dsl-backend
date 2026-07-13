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
  blog_url: z.string().min(1, 'blog_url is required'),
  author_name: z.string().optional(),
  meta_title: z.string().optional(),
  meta_description: z.string().optional(),
  meta_keywords: z.string().optional(),
  seo_tags: z.string().optional(),

  title: z.string().min(1, 'title is required'),
  description: z.string().optional(),
  small_img_name: z.string().optional(),
  small_img_alt: z.string().optional(),
  large_img_name: z.string().optional(),
  large_img_alt: z.string().optional(),

  title_cn: z.string().optional(),
  description_cn: z.string().optional(),
  small_img_name_cn: z.string().optional(),
  small_img_alt_cn: z.string().optional(),
  large_img_name_cn: z.string().optional(),
  large_img_alt_cn: z.string().optional(),

  title_ar: z.string().optional(),
  description_ar: z.string().optional(),
  small_img_name_ar: z.string().optional(),
  small_img_alt_ar: z.string().optional(),
  large_img_name_ar: z.string().optional(),
  large_img_alt_ar: z.string().optional(),

  blog_category: z.number().int().optional(),
  status: z.coerce.number().int().optional(),
});

export const updateBlogSchema = createBlogSchema.partial();

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
