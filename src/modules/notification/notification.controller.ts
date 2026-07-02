import { Request, Response, NextFunction } from 'express';
import { NotificationService } from './notification.service';
import { successResponse } from '../../shared/utils/response.util';

const notificationService = new NotificationService();

export async function sendNotification(req: Request, res: Response, next: NextFunction) {
  try {
    const { deviceTokens, title, body } = req.body;
    const result = await notificationService.sendPushNotification(deviceTokens, title, body);
    return res.status(200).json(successResponse(200, result.message, result));
  } catch (error) {
    next(error);
  }
}
