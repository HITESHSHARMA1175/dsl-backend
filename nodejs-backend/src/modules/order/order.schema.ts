import { z } from 'zod';

export const updateOrderStatusSchema = z.object({
  order_status: z.string().min(1, 'Order status is required'),
});

export const updateOrderAppointmentSchema = z.object({
  appointment_date: z.string().min(1, 'appointment_date is required'),
  appointment_slot: z.string().min(1, 'appointment_slot is required'),
});
