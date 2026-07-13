import { Request, Response, NextFunction } from 'express';
import { AppError } from '../../shared/utils/appError';
import { successResponse } from '../../shared/utils/response.util';

export async function uploadImage(req: Request, res: Response, next: NextFunction) {
  try {
    if (!req.file) {
      throw new AppError(400, 'No image file provided');
    }
    return res.status(201).json(successResponse(201, 'Image uploaded', {
      filename: req.file.filename,
      url: `/uploads/${req.file.filename}`,
    }));
  } catch (error) {
    next(error);
  }
}
