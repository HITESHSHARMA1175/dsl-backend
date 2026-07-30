const fs = require('fs');
const path = require('path');
const dotenv = require('dotenv');
const { PrismaClient } = require('@prisma/client');

dotenv.config({ path: path.join(__dirname, '..', '.env') });

const prisma = new PrismaClient();

const slugify = (value) => String(value || '')
  .toLowerCase()
  .trim()
  .replace(/[^a-z0-9]+/g, '-')
  .replace(/(^-|-$)/g, '');

const statusToNumber = (status) => {
  const normalized = String(status || '').toLowerCase().trim();
  if (normalized === 'active' || normalized === 'published' || normalized === '1') return 1;
  if (normalized === 'archived' || normalized === '2') return 2;
  return 0;
};

const cleanFaqs = (faqs) => (
  Array.isArray(faqs)
    ? faqs
      .map((faq) => ({
        question: String(faq?.question || '').trim(),
        answer: String(faq?.answer || '').trim(),
      }))
      .filter((faq) => faq.question && faq.answer)
    : []
);

const getDefaultOptionId = (pricing) => {
  const options = Array.isArray(pricing?.options) ? pricing.options : [];
  return (options.find((option) => option?.popular) || options[0] || {}).id || null;
};

async function upsertCategory(name, order) {
  const categoryName = String(name || '').trim();
  if (!categoryName) return null;

  const categorySlug = slugify(categoryName);
  const existing = await prisma.property_category_mains.findFirst({
    where: { category_slug: categorySlug, parent_id: null },
    orderBy: { id: 'desc' },
  });

  const data = {
    parent_id: null,
    category_name: categoryName,
    category_slug: categorySlug,
    sorting_order: order,
    status: 1,
  };

  if (existing) {
    return prisma.property_category_mains.update({
      where: { id: existing.id },
      data,
    });
  }

  return prisma.property_category_mains.create({ data });
}

const buildTreatmentPageData = (item, categoryId) => ({
  category_id: categoryId,
  sub_category_id: null,
  treatment_name: item.name || item.slug,
  slug: item.slug,
  short_description: item.hero?.description || null,
  full_description: item.detail?.description || null,
  hero_title: item.hero?.title || item.name || null,
  hero_eyebrow: item.hero?.eyebrow || item.type || null,
  hero_accent_title: item.hero?.accentTitle || null,
  hero_image: item.hero?.image || null,
  hero_image_alt: item.hero?.imageAlt || item.name || null,
  hero_badge_text: item.hero?.badgeText || null,
  detail: item.detail || null,
  default_option_id: item.defaultOptionId || getDefaultOptionId(item.pricing),
  pricing: item.pricing || null,
  stats: Array.isArray(item.stats) ? item.stats : [],
  status: statusToNumber(item.status),
  sections: [
    { type: 'hero', data: item.hero || {} },
    { type: 'detail', data: item.detail || {} },
    { type: 'pricing', data: item.pricing || {} },
    { type: 'stats', data: Array.isArray(item.stats) ? item.stats : [] },
  ],
});

async function main() {
  const inputPath = path.join(__dirname, '..', '..', 'treatmentdata.json');
  const raw = fs.readFileSync(inputPath, 'utf8');
  const treatments = JSON.parse(raw);

  if (!Array.isArray(treatments)) {
    throw new Error('treatmentdata.json must be an array');
  }

  const categoryOrder = new Map();
  let created = 0;
  let updated = 0;
  let faqRows = 0;

  for (const item of treatments) {
    const name = String(item?.name || '').trim();
    const slug = String(item?.slug || '').trim();
    if (!name || !slug) {
      console.warn('Skipping treatment without name or slug:', item);
      continue;
    }

    if (!categoryOrder.has(item.type)) categoryOrder.set(item.type, categoryOrder.size + 1);
    const category = await upsertCategory(item.type, categoryOrder.get(item.type));
    const categoryId = category ? Number(category.id) : null;
    const data = buildTreatmentPageData({ ...item, name, slug }, categoryId);
    const existing = await prisma.treatmentPage.findUnique({ where: { slug } });

    const page = existing
      ? await prisma.treatmentPage.update({ where: { id: existing.id }, data })
      : await prisma.treatmentPage.create({ data });

    if (existing) updated += 1;
    else created += 1;

    const faqs = cleanFaqs(item.faqs);
    await prisma.treatmentFaq.deleteMany({ where: { treatment_page_id: page.id } });
    if (faqs.length > 0) {
      await prisma.treatmentFaq.createMany({
        data: faqs.map((faq, index) => ({
          treatment_page_id: page.id,
          question: faq.question,
          answer: faq.answer,
          sorting_order: index,
          status: 1,
        })),
      });
      faqRows += faqs.length;
    }
  }

  console.log(JSON.stringify({
    total: treatments.length,
    created,
    updated,
    faqRows,
    categories: categoryOrder.size,
  }, null, 2));
}

main()
  .catch((error) => {
    console.error(error);
    process.exitCode = 1;
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
