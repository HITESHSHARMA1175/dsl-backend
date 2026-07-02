import { z } from 'zod';

export const markAttendanceSchema = z.object({
  current_location: z.string().optional(),
  attendance_date: z.string().optional(),
  attendance_time: z.string().optional(),
});

export const punchOutSchema = z.object({
  punch_out_time: z.string().optional(),
});

export const addLeaveSchema = z.object({
  leave_type: z.string().min(1, 'Leave type is required'),
  day_type: z.string().optional(),
  leave_date: z.string().min(1, 'Leave date is required'),
});
