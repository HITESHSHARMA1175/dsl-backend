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
  question: z.string().optional(),
  answer: z.string().optional(),
});

const translationsSchema = z.record(z.any()).optional();

const pageDataSchema = z.object({
  defaultOptionId: z.string().optional(),
  hero: heroSchema.optional(),
  detail: detailSchema.optional(),
  pricing: pricingSchema.optional(),
  stats: z.array(statSchema).optional(),
  results: resultsSchema.optional(),
  faqs: z.array(faqSchema).optional(),
  translations: translationsSchema,
});

export const createTreatmentContractSchema = z.object({
  name: z.string().min(1, 'name is required'),
  slug: z.string().min(1, 'slug is required'),
  type: z.string().optional(),
  category_id: z.number().int().optional(),
  sub_category_id: z.number().int().optional(),
  pageData: pageDataSchema.optional(),
});

export const updateTreatmentContractSchema = z.object({
  name: z.string().optional(),
  slug: z.string().optional(),
  type: z.string().optional(),
  category_id: z.number().int().nullable().optional(),
  sub_category_id: z.number().int().nullable().optional(),
  pageData: pageDataSchema.optional(),
});

const navbarItemSchema = z.object({
  id: z.number().int().optional(),
  name: z.string().min(1, 'link name is required'),
  slug: z.string().optional(),
  path: z.string().optional(),
});

const navbarColumnSchema = z.object({
  id: z.number().int().optional(),
  title: z.string().min(1, 'column title is required'),
  subItems: z.array(navbarItemSchema).optional().default([]),
});

const navbarGroupSchema = z.object({
  id: z.number().int().optional(),
  name: z.string().min(1, 'category name is required'),
  isMultiColumn: z.boolean().optional().default(false),
  subItems: z.array(navbarItemSchema).optional().default([]),
  columns: z.array(navbarColumnSchema).optional().default([]),
});

export const updateNavbarSchema = z.object({
  menu: z.array(navbarGroupSchema),
});
