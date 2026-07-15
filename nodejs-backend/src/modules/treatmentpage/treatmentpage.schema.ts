import { z } from 'zod';

const pricingOptionSchema = z.object({
  id: z.string().min(1, 'option id is required'),
  name: z.string().min(1, 'option name is required'),
  sessions: z.string().optional(),
  originalPrice: z.string().optional(),
  total: z.string().optional(),
  saveText: z.string().optional(),
  popular: z.boolean().optional(),
});

const pricingSchema = z.object({
  title: z.string().optional(),
  description: z.string().optional(),
  selectedLabel: z.string().optional(),
  options: z.array(pricingOptionSchema).optional(),
});

const statSchema = z.object({
  icon: z.string().optional(),
  label: z.string().optional(),
  value: z.string().optional(),
});

const galleryImageSchema = z.object({
  url: z.string().min(1),
  alt: z.string().optional(),
});

const beforeAfterItemSchema = z.object({
  label: z.string().optional(),
  before: z.string().min(1, 'before image is required'),
  after: z.string().min(1, 'after image is required'),
});

const procedureStepSchema = z.object({
  title: z.string().optional(),
  description: z.string().optional(),
});

const sectionSchema = z.object({
  type: z.string().min(1, 'section type is required'),
}).catchall(z.any());

export const createTreatmentPageSchema = z.object({
  slug: z.string().min(1, 'slug is required'),
  service_id: z.number().int().optional(),
  treatment_name: z.string().optional(),

  short_description: z.string().optional(),
  full_description: z.string().optional(),

  hero_title: z.string().optional(),
  hero_subtitle: z.string().optional(),
  hero_image: z.string().optional(),

  gallery_images: z.array(galleryImageSchema).optional(),
  before_after: z.array(beforeAfterItemSchema).optional(),
  benefits: z.array(z.string()).optional(),
  procedure: z.array(procedureStepSchema).optional(),
  who_is_it_for: z.array(z.string()).optional(),
  risks: z.array(z.string()).optional(),

  duration: z.string().optional(),
  recovery_time: z.string().optional(),
  results: z.string().optional(),
  cost: z.string().optional(),

  default_option_id: z.string().optional(),
  pricing: pricingSchema.optional(),
  stats: z.array(statSchema).optional(),

  cta_text: z.string().optional(),
  cta_link: z.string().optional(),

  seo_title: z.string().optional(),
  seo_description: z.string().optional(),
  seo_keywords: z.string().optional(),
  og_image: z.string().optional(),

  related_treatment_ids: z.array(z.number().int()).optional(),
  sections: z.array(sectionSchema).optional(),

  status: z.coerce.number().int().min(0).max(2).optional(),
});

export const updateTreatmentPageSchema = createTreatmentPageSchema.partial();

// ==================== FAQs ====================

export const createTreatmentFaqSchema = z.object({
  question: z.string().min(1, 'question is required'),
  answer: z.string().min(1, 'answer is required'),
  sorting_order: z.number().int().optional(),
  status: z.coerce.number().int().min(0).max(1).optional(),
});

export const updateTreatmentFaqSchema = createTreatmentFaqSchema.partial();

export const reorderTreatmentFaqSchema = z.object({
  items: z.array(z.object({
    id: z.number().int(),
    sorting_order: z.number().int(),
  })).min(1, 'items array is required'),
});

// ==================== Reviews ====================

export const createTreatmentReviewSchema = z.object({
  patient_name: z.string().min(1, 'patient_name is required'),
  rating: z.number().int().min(1).max(5),
  review_text: z.string().optional(),
  patient_image: z.string().optional(),
  treatment_received: z.string().optional(),
  review_date: z.string().optional(),
  sorting_order: z.number().int().optional(),
  status: z.coerce.number().int().min(0).max(1).optional(),
});

export const updateTreatmentReviewSchema = createTreatmentReviewSchema.partial();

export const reorderTreatmentReviewSchema = z.object({
  items: z.array(z.object({
    id: z.number().int(),
    sorting_order: z.number().int(),
  })).min(1, 'items array is required'),
});
