import { Request, Response, NextFunction } from 'express';
import { ContentService } from './content.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const contentService = new ContentService(prisma);

// --- Banner Handlers ---

export async function listBanners(req: Request, res: Response, next: NextFunction) {
  try {
    const banners = await contentService.listBanners();
    return res.status(200).json(successResponse(200, 'Success', banners));
  } catch (error) {
    next(error);
  }
}

export async function createBanner(req: Request, res: Response, next: NextFunction) {
  try {
    const banner = await contentService.createBanner(req.body);
    return res.status(201).json(successResponse(201, 'Banner created', banner));
  } catch (error) {
    next(error);
  }
}

export async function updateBanner(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const banner = await contentService.updateBanner(id, req.body);
    return res.status(200).json(successResponse(200, 'Banner updated', banner));
  } catch (error) {
    next(error);
  }
}

export async function removeBanner(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    await contentService.deleteBanner(id);
    return res.status(200).json(successResponse(200, 'Banner deleted', null));
  } catch (error) {
    next(error);
  }
}

export async function toggleBannerStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const banner = await contentService.toggleBannerStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', banner));
  } catch (error) {
    next(error);
  }
}

// --- Review Handlers ---

export async function listReviews(req: Request, res: Response, next: NextFunction) {
  try {
    const reviews = await contentService.listReviews();
    return res.status(200).json(successResponse(200, 'Success', reviews));
  } catch (error) {
    next(error);
  }
}

export async function createReview(req: Request, res: Response, next: NextFunction) {
  try {
    const review = await contentService.createReview(req.body);
    return res.status(201).json(successResponse(201, 'Review created', review));
  } catch (error) {
    next(error);
  }
}

export async function updateReview(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const review = await contentService.updateReview(id, req.body);
    return res.status(200).json(successResponse(200, 'Review updated', review));
  } catch (error) {
    next(error);
  }
}

export async function removeReview(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    await contentService.deleteReview(id);
    return res.status(200).json(successResponse(200, 'Review deleted', null));
  } catch (error) {
    next(error);
  }
}

export async function toggleReviewStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const review = await contentService.toggleReviewStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', review));
  } catch (error) {
    next(error);
  }
}

// --- FAQ Handlers ---

export async function listFaqs(req: Request, res: Response, next: NextFunction) {
  try {
    const faqs = await contentService.listFaqs();
    return res.status(200).json(successResponse(200, 'Success', faqs));
  } catch (error) {
    next(error);
  }
}

export async function createFaq(req: Request, res: Response, next: NextFunction) {
  try {
    const faq = await contentService.createFaq(req.body);
    return res.status(201).json(successResponse(201, 'FAQ created', faq));
  } catch (error) {
    next(error);
  }
}

export async function updateFaq(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const faq = await contentService.updateFaq(id, req.body);
    return res.status(200).json(successResponse(200, 'FAQ updated', faq));
  } catch (error) {
    next(error);
  }
}

export async function removeFaq(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    await contentService.deleteFaq(id);
    return res.status(200).json(successResponse(200, 'FAQ deleted', null));
  } catch (error) {
    next(error);
  }
}

export async function toggleFaqStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const faq = await contentService.toggleFaqStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', faq));
  } catch (error) {
    next(error);
  }
}

export async function updateFaqSorting(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await contentService.updateFaqSorting(req.body.items);
    return res.status(200).json(successResponse(200, 'FAQ sorting updated', result));
  } catch (error) {
    next(error);
  }
}

// --- Blog Handlers ---

export async function listBlogs(req: Request, res: Response, next: NextFunction) {
  try {
    const blogs = await contentService.listBlogs();
    return res.status(200).json(successResponse(200, 'Success', blogs));
  } catch (error) {
    next(error);
  }
}

export async function createBlog(req: Request, res: Response, next: NextFunction) {
  try {
    const blog = await contentService.createBlog(req.body);
    return res.status(201).json(successResponse(201, 'Blog created', blog));
  } catch (error) {
    next(error);
  }
}

export async function updateBlog(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const blog = await contentService.updateBlog(id, req.body);
    return res.status(200).json(successResponse(200, 'Blog updated', blog));
  } catch (error) {
    next(error);
  }
}

export async function removeBlog(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    await contentService.deleteBlog(id);
    return res.status(200).json(successResponse(200, 'Blog deleted', null));
  } catch (error) {
    next(error);
  }
}

export async function toggleBlogStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const blog = await contentService.toggleBlogStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', blog));
  } catch (error) {
    next(error);
  }
}

// --- SEO Handlers ---

export async function listSeo(req: Request, res: Response, next: NextFunction) {
  try {
    const seoEntries = await contentService.listSeo();
    return res.status(200).json(successResponse(200, 'Success', seoEntries));
  } catch (error) {
    next(error);
  }
}

export async function createSeo(req: Request, res: Response, next: NextFunction) {
  try {
    const seo = await contentService.createSeo(req.body);
    return res.status(201).json(successResponse(201, 'SEO entry created', seo));
  } catch (error) {
    next(error);
  }
}

export async function updateSeo(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const seo = await contentService.updateSeo(id, req.body);
    return res.status(200).json(successResponse(200, 'SEO entry updated', seo));
  } catch (error) {
    next(error);
  }
}

export async function removeSeo(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    await contentService.deleteSeo(id);
    return res.status(200).json(successResponse(200, 'SEO entry deleted', null));
  } catch (error) {
    next(error);
  }
}

// --- Public (storefront) read handlers ---

export async function publicBanners(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await contentService.publicBanners();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function publicReviews(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await contentService.publicReviews();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function publicFaqs(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await contentService.publicFaqs();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function publicBlogs(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await contentService.publicBlogs();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function publicBlogDetail(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await contentService.publicBlogBySlug(String(req.params.slug));
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}

export async function publicSeo(req: Request, res: Response, next: NextFunction) {
  try {
    const pageurl = (req.query.pageurl as string) || (req.query.slug as string) || '';
    const data = await contentService.publicSeoByUrl(pageurl);
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}
