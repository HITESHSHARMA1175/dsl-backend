import { Request, Response, NextFunction } from 'express';
import { HomeService } from './home.service';
import { successResponse } from '../../shared/utils/response.util';

const homeService = new HomeService();

export async function getHomePage(req: Request, res: Response, next: NextFunction) {
  try {
    const data = await homeService.getHomePage();
    return res.status(200).json(successResponse(200, 'Success', data));
  } catch (error) {
    next(error);
  }
}
