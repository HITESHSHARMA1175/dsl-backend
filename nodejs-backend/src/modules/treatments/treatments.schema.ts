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

const statSchema = z.object({
  icon: z.string().optional(),
  label: z.string().optional(),
  value: z.string().optional(),
});

const pricingOptionSchema = z.object({
  id: z.string().optional(),
  name: z.string().optional(),
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

const resultItemSchema = z.object({
  label: z.string().optional(),
  before: z.string().optional(),
  after: z.string().optional(),
  beforeLabel: z.string().optional(),
  afterLabel: z.string().optional(),
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

const pageDataSchema = z.object({
  defaultOptionId: z.string().optional(),
  hero: heroSchema.optional(),
  detail: detailSchema.optional(),
  pricing: pricingSchema.optional(),
  stats: z.array(statSchema).optional(),
  results: resultsSchema.optional(),
  faqs: z.array(faqSchema).optional(),
});

export const createTreatmentContractSchema = z.object({
  name: z.string().min(1, 'name is required'),
  slug: z.string().min(1, 'slug is required'),
  pageData: pageDataSchema.optional(),
});

export const updateTreatmentContractSchema = z.object({
  name: z.string().optional(),
  slug: z.string().optional(),
  pageData: pageDataSchema.optional(),
});
