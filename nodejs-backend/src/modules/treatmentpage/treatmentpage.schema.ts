import { z } from 'zod';

const heroSchema = z.object({
  eyebrow: z.string().optional(),
  title: z.string().optional(),
  accentTitle: z.string().optional(),
  description: z.string().optional(),
  image: z.string().optional(),
  imageAlt: z.string().optional(),
  badgeText: z.string().optional(),
});

const detailSchema = z.object({
  image: z.string().optional(),
  imageAlt: z.string().optional(),
  badge: z.string().optional(),
  title: z.string().optional(),
  description: z.string().optional(),
  footer: z.string().optional(),
});

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

const resultItemSchema = z.object({
  label: z.string().optional(),
  before: z.string().optional(),
  after: z.string().optional(),
});

const resultsSchema = z.object({
  eyebrow: z.string().optional(),
  title: z.string().optional(),
  description: z.string().optional(),
  items: z.array(resultItemSchema).optional(),
});

const faqSchema = z.object({
  question: z.string().min(1, 'question is required'),
  answer: z.string().min(1, 'answer is required'),
});

export const createTreatmentPageSchema = z.object({
  slug: z.string().min(1, 'slug is required'),
  service_id: z.number().int().optional(),
  default_option_id: z.string().optional(),
  hero: heroSchema.optional(),
  detail: detailSchema.optional(),
  pricing: pricingSchema.optional(),
  stats: z.array(statSchema).optional(),
  results: resultsSchema.optional(),
  faqs: z.array(faqSchema).optional(),
  status: z.coerce.number().int().optional(),
});

export const updateTreatmentPageSchema = createTreatmentPageSchema.partial();
