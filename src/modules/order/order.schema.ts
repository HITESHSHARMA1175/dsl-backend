import { z } from 'zod';

export const updateOrderStatusSchema = z.object({
  order_status: z.string().min(1, 'Order status is required'),
});
