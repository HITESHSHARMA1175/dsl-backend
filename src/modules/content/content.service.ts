import { PrismaClient } from '@prisma/client';

export class ContentService {
  constructor(private prisma: PrismaClient) {}

  // --- Banner ---

  async listBanners() {
    return this.prisma.banner.findMany();
  }

  async createBanner(data: { title: string; image?: string; link?: string; status?: string }) {
    return this.prisma.banner.create({ data });
  }

  async updateBanner(id: number, data: { title?: string; image?: string; link?: string; status?: string }) {
    return this.prisma.banner.update({ where: { id }, data });
  }

  async deleteBanner(id: number) {
    await this.prisma.banner.delete({ where: { id } });
    return { message: 'Banner deleted successfully' };
  }

  async toggleBannerStatus(id: number) {
    const record = await this.prisma.banner.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.banner.update({ where: { id }, data: { status: newStatus } });
  }

  // --- Review ---

  async listReviews() {
    return this.prisma.review.findMany();
  }

  async createReview(data: { name: string; rating: number; review?: string; status?: string }) {
    return this.prisma.review.create({ data });
  }

  async updateReview(id: number, data: { name?: string; rating?: number; review?: string; status?: string }) {
    return this.prisma.review.update({ where: { id }, data });
  }

  async deleteReview(id: number) {
    await this.prisma.review.delete({ where: { id } });
    return { message: 'Review deleted successfully' };
  }

  async toggleReviewStatus(id: number) {
    const record = await this.prisma.review.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.review.update({ where: { id }, data: { status: newStatus } });
  }

  // --- FAQ ---

  async listFaqs() {
    return this.prisma.faq.findMany({ orderBy: { sorting_order: 'asc' } });
  }

  async createFaq(data: { question: string; answer?: string; sorting_order?: number; status?: string }) {
    return this.prisma.faq.create({ data });
  }

  async updateFaq(id: number, data: { question?: string; answer?: string; sorting_order?: number; status?: string }) {
    return this.prisma.faq.update({ where: { id }, data });
  }

  async deleteFaq(id: number) {
    await this.prisma.faq.delete({ where: { id } });
    return { message: 'FAQ deleted successfully' };
  }

  async toggleFaqStatus(id: number) {
    const record = await this.prisma.faq.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.faq.update({ where: { id }, data: { status: newStatus } });
  }

  async updateFaqSorting(items: { id: number; sorting_order: number }[]) {
    const updates = items.map((item) =>
      this.prisma.faq.update({
        where: { id: item.id },
        data: { sorting_order: item.sorting_order },
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
    status?: string;
  }) {
    return this.prisma.blog.create({ data });
  }

  async updateBlog(id: number, data: {
    title?: string;
    slug?: string;
    content?: string;
    blog_category?: number;
    image?: string;
    status?: string;
  }) {
    return this.prisma.blog.update({ where: { id }, data });
  }

  async deleteBlog(id: number) {
    await this.prisma.blog.delete({ where: { id } });
    return { message: 'Blog deleted successfully' };
  }

  async toggleBlogStatus(id: number) {
    const record = await this.prisma.blog.findUniqueOrThrow({ where: { id } });
    const newStatus = record.status === '1' ? '0' : '1';
    return this.prisma.blog.update({ where: { id }, data: { status: newStatus } });
  }

  // --- SEO ---

  async listSeo() {
    return this.prisma.seo.findMany();
  }

  async createSeo(data: {
    page_name: string;
    meta_title?: string;
    meta_description?: string;
    meta_keywords?: string;
    status?: string;
  }) {
    return this.prisma.seo.create({ data });
  }

  async updateSeo(id: number, data: {
    page_name?: string;
    meta_title?: string;
    meta_description?: string;
    meta_keywords?: string;
    status?: string;
  }) {
    return this.prisma.seo.update({ where: { id }, data });
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
