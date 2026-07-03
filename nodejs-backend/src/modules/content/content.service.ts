import { PrismaClient } from '@prisma/client';

export class ContentService {
  constructor(private prisma: PrismaClient) {}

  // --- Banner ---

  async listBanners() {
    return this.prisma.banner.findMany();
  }

  async createBanner(data: { title: string; image?: string; link?: string; status?: number }) {
    return this.prisma.banner.create({
      data: {
        banner_name: data.title,
        profile: data.image,
        banner_url: data.link,
        status: data.status,
      },
    });
  }

  async updateBanner(id: number, data: { title?: string; image?: string; link?: string; status?: number }) {
    return this.prisma.banner.update({
      where: { id },
      data: {
        banner_name: data.title,
        profile: data.image,
        banner_url: data.link,
        status: data.status,
      },
    });
  }

  async deleteBanner(id: number) {
    await this.prisma.banner.delete({ where: { id } });
    return { message: 'Banner deleted successfully' };
  }

  async toggleBannerStatus(id: number) {
    const record = await this.prisma.banner.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === 1 ? 0 : 1;
    return this.prisma.banner.update({ where: { id }, data: { status: newStatus } });
  }

  // --- Review ---

  async listReviews() {
    return this.prisma.review.findMany();
  }

  async createReview(data: { name: string; rating: number; review?: string; status?: number }) {
    return this.prisma.review.create({
      data: {
        full_name: data.name,
        rating: String(data.rating),
        description: data.review,
        status: data.status,
      },
    });
  }

  async updateReview(id: number, data: { name?: string; rating?: number; review?: string; status?: number }) {
    return this.prisma.review.update({
      where: { id },
      data: {
        full_name: data.name,
        rating: data.rating !== undefined ? String(data.rating) : undefined,
        description: data.review,
        status: data.status,
      },
    });
  }

  async deleteReview(id: number) {
    await this.prisma.review.delete({ where: { id } });
    return { message: 'Review deleted successfully' };
  }

  async toggleReviewStatus(id: number) {
    const record = await this.prisma.review.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === 1 ? 0 : 1;
    return this.prisma.review.update({ where: { id }, data: { status: newStatus } });
  }

  // --- FAQ ---

  // `faqs.created_at`/`updated_at` have legacy zero-dates ("0000-00-00") that
  // break Prisma's default deserialization, so every faq query below uses an
  // explicit select that omits those columns.
  private static readonly FAQ_SELECT = {
    id: true,
    category_id: true,
    question: true,
    answer: true,
    sorting_order: true,
    status: true,
  } as const;

  async listFaqs() {
    return this.prisma.faq.findMany({
      orderBy: { sorting_order: 'asc' },
      select: ContentService.FAQ_SELECT,
    });
  }

  async createFaq(data: { category_id: number; question: string; answer?: string; sorting_order?: number; status?: number }) {
    return this.prisma.faq.create({ data, select: ContentService.FAQ_SELECT });
  }

  async updateFaq(
    id: number,
    data: { category_id?: number; question?: string; answer?: string; sorting_order?: number; status?: number }
  ) {
    return this.prisma.faq.update({ where: { id }, data, select: ContentService.FAQ_SELECT });
  }

  async deleteFaq(id: number) {
    await this.prisma.faq.delete({ where: { id }, select: { id: true } });
    return { message: 'FAQ deleted successfully' };
  }

  async toggleFaqStatus(id: number) {
    const record = await this.prisma.faq.findUniqueOrThrow({ where: { id }, select: ContentService.FAQ_SELECT });
    const newStatus = record.status === 1 ? 0 : 1;
    return this.prisma.faq.update({ where: { id }, data: { status: newStatus }, select: ContentService.FAQ_SELECT });
  }

  async updateFaqSorting(items: { id: number; sorting_order: number }[]) {
    const updates = items.map((item) =>
      this.prisma.faq.update({
        where: { id: item.id },
        data: { sorting_order: item.sorting_order },
        select: { id: true },
      })
    );
    await this.prisma.$transaction(updates);
    return { message: 'FAQ sorting updated successfully' };
  }

  // --- Blog ---

  async listBlogs() {
    return this.prisma.blog.findMany();
  }

  async createBlog(data: {
    title: string;
    slug?: string;
    content?: string;
    blog_category?: number;
    image?: string;
    status?: number;
  }) {
    return this.prisma.blog.create({
      data: {
        title: data.title,
        blog_slug: data.slug,
        description: data.content,
        blog_category: data.blog_category,
        profile: data.image,
        status: data.status,
      },
    });
  }

  async updateBlog(
    id: number,
    data: {
      title?: string;
      slug?: string;
      content?: string;
      blog_category?: number;
      image?: string;
      status?: number;
    }
  ) {
    return this.prisma.blog.update({
      where: { id },
      data: {
        title: data.title,
        blog_slug: data.slug,
        description: data.content,
        blog_category: data.blog_category,
        profile: data.image,
        status: data.status,
      },
    });
  }

  async deleteBlog(id: number) {
    await this.prisma.blog.delete({ where: { id } });
    return { message: 'Blog deleted successfully' };
  }

  async toggleBlogStatus(id: number) {
    const record = await this.prisma.blog.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === 1 ? 0 : 1;
    return this.prisma.blog.update({ where: { id }, data: { status: newStatus } });
  }

  // --- SEO ---

  async listSeo() {
    return this.prisma.seo.findMany();
  }

  async createSeo(data: {
    page_name: string;
    pageurl?: string;
    meta_title?: string;
    meta_description?: string;
    meta_keywords?: string;
    status?: number;
  }) {
    return this.prisma.seo.create({
      data: {
        title: data.page_name,
        pageurl: data.pageurl,
        meta_title: data.meta_title,
        meta_description: data.meta_description,
        meta_keywords: data.meta_keywords,
        status: data.status,
      },
    });
  }

  async updateSeo(
    id: number,
    data: {
      page_name?: string;
      pageurl?: string;
      meta_title?: string;
      meta_description?: string;
      meta_keywords?: string;
      status?: number;
    }
  ) {
    return this.prisma.seo.update({
      where: { id },
      data: {
        title: data.page_name,
        pageurl: data.pageurl,
        meta_title: data.meta_title,
        meta_description: data.meta_description,
        meta_keywords: data.meta_keywords,
        status: data.status,
      },
    });
  }

  async deleteSeo(id: number) {
    await this.prisma.seo.delete({ where: { id } });
    return { message: 'SEO entry deleted successfully' };
  }

  // --- Public (storefront) read methods ---

  async publicBanners() {
    return (this.prisma as any).banner.findMany({ where: { status: 1 } });
  }

  async publicReviews() {
    return (this.prisma as any).review.findMany({ where: { status: 1 }, orderBy: { id: 'desc' } });
  }

  async publicFaqs() {
    // Raw query with explicit columns — `faqs.created_at` has legacy zero-dates
    // that break Prisma's default selection.
    return (this.prisma as any).$queryRawUnsafe(
      `SELECT id, category_id, question, answer, sorting_order, status
       FROM faqs WHERE status = 1 ORDER BY sorting_order ASC`
    );
  }

  async publicBlogs() {
    return (this.prisma as any).blog.findMany({ where: { status: 1 }, orderBy: { id: 'desc' } });
  }

  async publicBlogBySlug(slug: string) {
    const blog = await (this.prisma as any).blog.findFirst({ where: { blog_slug: slug } });
    if (blog) return blog;
    // Fallback to numeric id lookup
    const asId = Number(slug);
    if (!Number.isNaN(asId)) {
      return (this.prisma as any).blog.findUnique({ where: { id: asId } });
    }
    return null;
  }

  async publicSeoByUrl(pageurl: string) {
    return (this.prisma as any).seo.findFirst({ where: { pageurl } });
  }
}
