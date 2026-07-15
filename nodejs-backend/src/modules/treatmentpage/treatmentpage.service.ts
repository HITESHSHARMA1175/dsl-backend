import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

export class TreatmentPageService {
  constructor(private prisma: PrismaClient) {}

  async list() {
    return this.prisma.treatmentPage.findMany({
      where: { status: 1 },
      select: {
        id: true, slug: true, treatment_name: true, hero_image: true,
        status: true, updated_at: true,
      },
      orderBy: { id: 'desc' },
    });
  }

  async listAdmin() {
    return this.prisma.treatmentPage.findMany({ orderBy: { id: 'desc' } });
  }

  private async resolveRelatedTreatments(ids: unknown): Promise<any[]> {
    if (!Array.isArray(ids) || ids.length === 0) return [];
    const numericIds = ids.filter((id): id is number => typeof id === 'number');
    if (numericIds.length === 0) return [];

    const related = await this.prisma.treatmentPage.findMany({
      where: { id: { in: numericIds }, status: 1 },
      select: { id: true, slug: true, treatment_name: true, hero_image: true },
    });
    const byId = new Map(related.map((r) => [r.id, r]));
    return numericIds.map((id) => byId.get(id)).filter(Boolean);
  }

  async getBySlug(slug: string) {
    const page = await this.prisma.treatmentPage.findUnique({
      where: { slug },
      include: {
        faqs: { where: { status: 1 }, orderBy: { sorting_order: 'asc' } },
        reviews: { where: { status: 1 }, orderBy: { sorting_order: 'asc' } },
      },
    });
    if (!page || page.status !== 1) {
      throw new AppError(404, 'Treatment page not found');
    }
    const relatedTreatments = await this.resolveRelatedTreatments(page.related_treatment_ids);
    return { ...page, relatedTreatments };
  }

  async getById(id: number) {
    const page = await this.prisma.treatmentPage.findUnique({
      where: { id },
      include: {
        faqs: { orderBy: { sorting_order: 'asc' } },
        reviews: { orderBy: { sorting_order: 'asc' } },
      },
    });
    if (!page) {
      throw new AppError(404, 'Treatment page not found');
    }
    return page;
  }

  async create(data: any) {
    const existing = await this.prisma.treatmentPage.findUnique({ where: { slug: data.slug } });
    if (existing) {
      throw new AppError(409, 'A treatment page with this slug already exists');
    }
    return this.prisma.treatmentPage.create({ data });
  }

  async update(id: number, data: any) {
    await this.getById(id);
    if (data.slug) {
      const existing = await this.prisma.treatmentPage.findUnique({ where: { slug: data.slug } });
      if (existing && existing.id !== id) {
        throw new AppError(409, 'A treatment page with this slug already exists');
      }
    }
    return this.prisma.treatmentPage.update({ where: { id }, data });
  }

  async delete(id: number) {
    await this.getById(id);
    await this.prisma.treatmentPage.delete({ where: { id } });
    return { message: 'Treatment page deleted successfully' };
  }

  async setStatus(id: number, status: 0 | 1 | 2) {
    await this.getById(id);
    return this.prisma.treatmentPage.update({ where: { id }, data: { status } });
  }

  // ==================== FAQs ====================

  private async assertFaqBelongsToPage(treatmentPageId: number, faqId: number) {
    const faq = await this.prisma.treatmentFaq.findUnique({ where: { id: faqId } });
    if (!faq || faq.treatment_page_id !== treatmentPageId) {
      throw new AppError(404, 'FAQ not found for this treatment page');
    }
    return faq;
  }

  async addFaq(treatmentPageId: number, data: any) {
    await this.getById(treatmentPageId);
    return this.prisma.treatmentFaq.create({
      data: { ...data, treatment_page_id: treatmentPageId },
    });
  }

  async updateFaq(treatmentPageId: number, faqId: number, data: any) {
    await this.assertFaqBelongsToPage(treatmentPageId, faqId);
    return this.prisma.treatmentFaq.update({ where: { id: faqId }, data });
  }

  async deleteFaq(treatmentPageId: number, faqId: number) {
    await this.assertFaqBelongsToPage(treatmentPageId, faqId);
    await this.prisma.treatmentFaq.delete({ where: { id: faqId } });
    return { message: 'FAQ deleted successfully' };
  }

  async toggleFaqStatus(treatmentPageId: number, faqId: number) {
    const faq = await this.assertFaqBelongsToPage(treatmentPageId, faqId);
    return this.prisma.treatmentFaq.update({
      where: { id: faqId },
      data: { status: faq.status === 1 ? 0 : 1 },
    });
  }

  async reorderFaqs(treatmentPageId: number, items: { id: number; sorting_order: number }[]) {
    await this.getById(treatmentPageId);
    await Promise.all(
      items.map((item) =>
        this.prisma.treatmentFaq.updateMany({
          where: { id: item.id, treatment_page_id: treatmentPageId },
          data: { sorting_order: item.sorting_order },
        })
      )
    );
    return { message: 'FAQ order updated successfully' };
  }

  // ==================== Reviews ====================

  private async assertReviewBelongsToPage(treatmentPageId: number, reviewId: number) {
    const review = await this.prisma.treatmentReview.findUnique({ where: { id: reviewId } });
    if (!review || review.treatment_page_id !== treatmentPageId) {
      throw new AppError(404, 'Review not found for this treatment page');
    }
    return review;
  }

  async addReview(treatmentPageId: number, data: any) {
    await this.getById(treatmentPageId);
    const payload = { ...data };
    if (payload.review_date) payload.review_date = new Date(payload.review_date);
    return this.prisma.treatmentReview.create({
      data: { ...payload, treatment_page_id: treatmentPageId },
    });
  }

  async updateReview(treatmentPageId: number, reviewId: number, data: any) {
    await this.assertReviewBelongsToPage(treatmentPageId, reviewId);
    const payload = { ...data };
    if (payload.review_date) payload.review_date = new Date(payload.review_date);
    return this.prisma.treatmentReview.update({ where: { id: reviewId }, data: payload });
  }

  async deleteReview(treatmentPageId: number, reviewId: number) {
    await this.assertReviewBelongsToPage(treatmentPageId, reviewId);
    await this.prisma.treatmentReview.delete({ where: { id: reviewId } });
    return { message: 'Review deleted successfully' };
  }

  async toggleReviewStatus(treatmentPageId: number, reviewId: number) {
    const review = await this.assertReviewBelongsToPage(treatmentPageId, reviewId);
    return this.prisma.treatmentReview.update({
      where: { id: reviewId },
      data: { status: review.status === 1 ? 0 : 1 },
    });
  }

  async reorderReviews(treatmentPageId: number, items: { id: number; sorting_order: number }[]) {
    await this.getById(treatmentPageId);
    await Promise.all(
      items.map((item) =>
        this.prisma.treatmentReview.updateMany({
          where: { id: item.id, treatment_page_id: treatmentPageId },
          data: { sorting_order: item.sorting_order },
        })
      )
    );
    return { message: 'Review order updated successfully' };
  }
}
