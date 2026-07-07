import { z } from 'zod';

export const sendNotificationSchema = z.object({
  deviceTokens: z.array(z.string()).min(1, 'At least one device token is required'),
  title: z.string().min(1, 'Title is required'),
  body: z.string().min(1, 'Body is required'),
});
