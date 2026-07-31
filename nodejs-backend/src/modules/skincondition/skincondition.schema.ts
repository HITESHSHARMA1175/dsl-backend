import { z } from 'zod';

const treatmentStatsSchema = z.object({
  treatment_time: z.string().optional(),
  num_sessions: z.string().optional(),
  results_duration: z.string().optional(),
  session_frequency: z.string().optional(),
  treatment_time_label_cn: z.string().optional(),
  num_sessions_label_cn: z.string().optional(),
  results_duration_label_cn: z.string().optional(),
  session_frequency_label_cn: z.string().optional(),
  treatment_time_label_ar: z.string().optional(),
  num_sessions_label_ar: z.string().optional(),
  results_duration_label_ar: z.string().optional(),
  session_frequency_label_ar: z.string().optional(),
  card_title_cn: z.string().optional(),
  card_title_ar: z.string().optional(),
  card_description_cn: z.string().optional(),
  card_description_ar: z.string().optional(),
  card_badge_cn: z.string().optional(),
  card_badge_ar: z.string().optional(),
  card_trust_label_cn: z.string().optional(),
  card_trust_label_ar: z.string().optional(),
  pricing_heading_cn: z.string().optional(),
  pricing_heading_ar: z.string().optional(),
  pricing_description_cn: z.string().optional(),
  pricing_description_ar: z.string().optional(),
  add_to_cart_label_cn: z.string().optional(),
  add_to_cart_label_ar: z.string().optional(),
  faq_heading_cn: z.string().optional(),
  faq_heading_ar: z.string().optional(),
  condition_guide_label_cn: z.string().optional(),
  condition_guide_label_ar: z.string().optional(),
  condition_guide_heading_cn: z.string().optional(),
  condition_guide_heading_ar: z.string().optional(),
}).passthrough();

const pricingPackageSchema = z.object({
  id: z.union([z.string(), z.number()]).optional(),
  name: z.string().optional(),
  name_cn: z.string().optional(),
  name_ar: z.string().optional(),
  sessions: z.string().optional(),
  sessions_cn: z.string().optional(),
  sessions_ar: z.string().optional(),
  original_price: z.union([z.string(), z.number()]).optional(),
  price: z.union([z.string(), z.number()]).optional(),
  popular: z.boolean().optional(),
}).passthrough();

const beforeAfterSchema = z.object({
  id: z.union([z.string(), z.number()]).optional(),
  before_image: z.string().optional(),
  after_image: z.string().optional(),
  caption: z.string().optional(),
});

const testimonialSchema = z.object({
  id: z.union([z.string(), z.number()]).optional(),
  name: z.string().optional(),
  rating: z.union([z.string(), z.number()]).optional(),
  source: z.string().optional(),
  date: z.string().optional(),
  text: z.string().optional(),
});

const faqSchema = z.object({
  id: z.union([z.string(), z.number()]).optional(),
  question: z.string().optional(),
  answer: z.string().optional(),
  question_cn: z.string().optional(),
  answer_cn: z.string().optional(),
  question_ar: z.string().optional(),
  answer_ar: z.string().optional(),
  sorting_order: z.union([z.string(), z.number()]).optional(),
  status: z.union([z.string(), z.number()]).optional(),
});

// Every field here maps to a real column on PropertyCategory. Previously this
// schema only allowed category_name/description/image ("image" isn't even a
// real column) - everything else the admin UI has fields for (icons, image1-4,
// the description3 rich-text field, slug, cn/ar translations, meta_*, status)
// was silently stripped by validate() before it ever reached the database.
export const createConditionSchema = z.object({
  category_name: z.string().min(1, 'Name is required'),
  category_slug: z.string().optional(),
  description: z.string().optional(),
  description1: z.string().optional(),
  description3: z.string().optional(),
  meta_title: z.string().optional(),
  meta_description: z.string().optional(),
  meta_keywords: z.string().optional(),
  icon: z.string().optional(),
  icon_large: z.string().optional(),
  image1: z.string().optional(),
  image2: z.string().optional(),
  image3: z.string().optional(),
  image4: z.string().optional(),
  category_name_cn: z.string().optional(),
  description_cn: z.string().optional(),
  description3_cn: z.string().optional(),
  category_name_ar: z.string().optional(),
  description_ar: z.string().optional(),
  description3_ar: z.string().optional(),
  hero_badge: z.string().optional(),
  card_title: z.string().optional(),
  card_description: z.string().optional(),
  card_badge: z.string().optional(),
  card_trust_label: z.string().optional(),
  treatment_stats: treatmentStatsSchema.optional(),
  pricing: z.array(pricingPackageSchema).optional(),
  before_after: z.array(beforeAfterSchema).optional(),
  testimonials: z.array(testimonialSchema).optional(),
  faqs: z.array(faqSchema).optional(),
  status: z.number().int().optional(),
});

export const updateConditionSchema = createConditionSchema.partial();

export const sortingSchema = z.object({
  items: z.array(
    z.object({
      id: z.number().int().positive(),
      sorting: z.number().int(),
    })
  ).min(1),
});

// Same table/model as conditions above (PropertyCategory), so the same
// missing-fields bug applies here too.
export const createSubConditionSchema = z.object({
  category_name: z.string().min(1, 'Name is required'),
  parent_id: z.number().int().positive('Parent ID is required'),
  category_slug: z.string().optional(),
  description: z.string().optional(),
  description3: z.string().optional(),
  meta_title: z.string().optional(),
  meta_description: z.string().optional(),
  meta_keywords: z.string().optional(),
  icon: z.string().optional(),
  icon_large: z.string().optional(),
  image1: z.string().optional(),
  image2: z.string().optional(),
  image3: z.string().optional(),
  image4: z.string().optional(),
  category_name_cn: z.string().optional(),
  description_cn: z.string().optional(),
  description3_cn: z.string().optional(),
  category_name_ar: z.string().optional(),
  description_ar: z.string().optional(),
  description3_ar: z.string().optional(),
  status: z.number().int().optional(),
});

export const updateSubConditionSchema = createSubConditionSchema.partial();

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
