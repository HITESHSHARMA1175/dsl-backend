import { z } from 'zod';

export const createPatientSchema = z.object({
  title: z.string().optional(),
  first_name: z.string().min(1, 'first_name is required'),
  last_name: z.string().optional(),
  email: z.string().email('email must be a valid email address').optional(),
  mobile: z.string().optional(),
  dob: z.string().optional(),
  gender: z.string().optional(),
  address1: z.string().optional(),
  address2: z.string().optional(),
  city: z.string().optional(),
  country: z.string().optional(),
  pincode: z.string().optional(),
  sex: z.string().optional(),
  marital_status: z.string().optional(),
});

export const updatePatientSchema = z.object({
  title: z.string().optional(),
  first_name: z.string().optional(),
  last_name: z.string().optional(),
  email: z.string().email('email must be a valid email address').optional(),
  mobile: z.string().optional(),
  dob: z.string().optional(),
  gender: z.string().optional(),
  address1: z.string().optional(),
  address2: z.string().optional(),
  city: z.string().optional(),
  country: z.string().optional(),
  pincode: z.string().optional(),
  sex: z.string().optional(),
  marital_status: z.string().optional(),
});

export const saveMedicalHistorySchema = z.object({
  medical_history: z.array(z.number().int()).min(1, 'medical_history array is required'),
});
