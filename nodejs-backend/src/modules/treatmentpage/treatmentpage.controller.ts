import { Request, Response, NextFunction } from 'express';
import { TreatmentPageService } from './treatmentpage.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const treatmentPageService = new TreatmentPageService(prisma);

export async function listTreatmentPages(req: Request, res: Response, next: NextFunction) {
  try {
    const categoryId = req.query.category_id !== undefined ? Number(req.query.category_id) : undefined;
    const subCategoryId = req.query.sub_category_id !== undefined ? Number(req.query.sub_category_id) : undefined;
    const pages = await treatmentPageService.list(categoryId, subCategoryId);
    return res.status(200).json(successResponse(200, 'Success', pages));
  } catch (error) {
    next(error);
  }
}

export async function listTreatmentPagesAdmin(req: Request, res: Response, next: NextFunction) {
  try {
    const pages = await treatmentPageService.listAdmin();
    return res.status(200).json(successResponse(200, 'Success', pages));
  } catch (error) {
    next(error);
  }
}

export async function getTreatmentPageBySlug(req: Request, res: Response, next: NextFunction) {
  try {
    const page = await treatmentPageService.getBySlug(String(req.params.slug));
    return res.status(200).json(successResponse(200, 'Success', page));
  } catch (error) {
    next(error);
  }
}

export async function getTreatmentPageById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', page));
  } catch (error) {
    next(error);
  }
}

export async function createTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const page = await treatmentPageService.create(req.body);
    return res.status(201).json(successResponse(201, 'Treatment page created', page));
  } catch (error) {
    next(error);
  }
}

export async function updateTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Treatment page updated', page));
  } catch (error) {
    next(error);
  }
}

export async function deleteTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await treatmentPageService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function publishTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.setStatus(id, 1);
    return res.status(200).json(successResponse(200, 'Treatment page published', page));
  } catch (error) {
    next(error);
  }
}

export async function unpublishTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.setStatus(id, 0);
    return res.status(200).json(successResponse(200, 'Treatment page unpublished', page));
  } catch (error) {
    next(error);
  }
}

export async function archiveTreatmentPage(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const page = await treatmentPageService.setStatus(id, 2);
    return res.status(200).json(successResponse(200, 'Treatment page archived', page));
  } catch (error) {
    next(error);
  }
}

// ==================== FAQs ====================

export async function addTreatmentFaq(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const faq = await treatmentPageService.addFaq(pageId, req.body);
    return res.status(201).json(successResponse(201, 'FAQ added', faq));
  } catch (error) {
    next(error);
  }
}

export async function updateTreatmentFaq(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const faqId = parseIdParam(req.params.faqId);
    const faq = await treatmentPageService.updateFaq(pageId, faqId, req.body);
    return res.status(200).json(successResponse(200, 'FAQ updated', faq));
  } catch (error) {
    next(error);
  }
}

export async function deleteTreatmentFaq(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const faqId = parseIdParam(req.params.faqId);
    const result = await treatmentPageService.deleteFaq(pageId, faqId);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleTreatmentFaqStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const faqId = parseIdParam(req.params.faqId);
    const faq = await treatmentPageService.toggleFaqStatus(pageId, faqId);
    return res.status(200).json(successResponse(200, 'FAQ status toggled', faq));
  } catch (error) {
    next(error);
  }
}

export async function reorderTreatmentFaqs(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const result = await treatmentPageService.reorderFaqs(pageId, req.body.items);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

// ==================== Reviews ====================

export async function addTreatmentReview(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const review = await treatmentPageService.addReview(pageId, req.body);
    return res.status(201).json(successResponse(201, 'Review added', review));
  } catch (error) {
    next(error);
  }
}

export async function updateTreatmentReview(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const reviewId = parseIdParam(req.params.reviewId);
    const review = await treatmentPageService.updateReview(pageId, reviewId, req.body);
    return res.status(200).json(successResponse(200, 'Review updated', review));
  } catch (error) {
    next(error);
  }
}

export async function deleteTreatmentReview(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const reviewId = parseIdParam(req.params.reviewId);
    const result = await treatmentPageService.deleteReview(pageId, reviewId);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleTreatmentReviewStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const reviewId = parseIdParam(req.params.reviewId);
    const review = await treatmentPageService.toggleReviewStatus(pageId, reviewId);
    return res.status(200).json(successResponse(200, 'Review status toggled', review));
  } catch (error) {
    next(error);
  }
}

export async function reorderTreatmentReviews(req: Request, res: Response, next: NextFunction) {
  try {
    const pageId = parseIdParam(req.params.id);
    const result = await treatmentPageService.reorderReviews(pageId, req.body.items);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}
