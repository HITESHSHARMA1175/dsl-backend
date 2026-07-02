import { z } from 'zod';

export const createAppointmentSchema = z.object({
  clinician_id: z.number().int({ message: 'clinician_id must be an integer' }),
  title: z.string().optional(),
  app_date: z.string().min(1, 'app_date is required'),
  app_duration: z.string().optional(),
  total_service_duration: z.string().optional(),
  app_time_id: z.string().optional(),
  app_time_start: z.string().optional(),
  app_time_end: z.string().optional(),
  app_purpose: z.string().optional(),
  app_patient: z.string().optional(),
  app_type: z.string().optional(),
  virtual_call: z.string().optional(),
  treatement_type: z.string().optional(),
  treatement: z.string().optional(),
  room: z.string().optional(),
  equipment: z.string().optional(),
  app_notes: z.string().optional(),
});

export const addNotesSchema = z.object({
  notes: z.string().min(1, 'notes is required'),
});

export const addLogsSchema = z.object({
  appointment_action: z.string().min(1, 'appointment_action is required'),
});
