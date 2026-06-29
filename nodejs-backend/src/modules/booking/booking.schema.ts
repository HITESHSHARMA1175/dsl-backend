import { z } from 'zod';

export const createBookingSchema = z.object({
  service_id: z.string().min(1, 'service_id is required'),
  profession_id: z.number().int({ message: 'profession_id must be an integer' }),
  slot_id: z.number().int({ message: 'slot_id must be an integer' }),
  slot_date: z.string().min(1, 'slot_date is required'),
  first_name: z.string().min(1, 'first_name is required'),
  last_name: z.string().min(1, 'last_name is required'),
  email: z.string().email('email must be a valid email address'),
  mobile: z.string().min(1, 'mobile is required'),
  addon_id: z.string().optional(),
  total_service_duration: z.number().int().optional(),
  total_addon_duration: z.number().int().optional(),
  slot_time: z.string().optional(),
  clinic_id: z.number().int().optional(),
});

export const updateStatusSchema = z.object({
  status: z.string().min(1, 'status is required'),
});
