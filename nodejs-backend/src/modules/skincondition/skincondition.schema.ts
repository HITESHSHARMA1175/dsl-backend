import { z } from 'zod';

// Every field here maps to a real column on PropertyCategory. Previously this
// schema only allowed category_name/description/image ("image" isn't even a
// real column) - everything else the admin UI has fields for (icons, image1-4,
// the description3 rich-text field, slug, cn/ar translations, meta_*, status)
// was silently stripped by validate() before it ever reached the database.
export const createConditionSchema = z.object({
  category_name: z.string().min(1, 'Name is required'),
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
  category_name_ar: z.string().optional(),
  description_ar: z.string().optional(),
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
  category_name_ar: z.string().optional(),
  description_ar: z.string().optional(),
  status: z.number().int().optional(),
});

export const updateSubConditionSchema = createSubConditionSchema.partial();
