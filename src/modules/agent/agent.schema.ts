import { z } from 'zod';

export const registerSchema = z.object({
  first_name: z.string().min(1, 'First name is required'),
  last_name: z.string().optional(),
  email: z.string().email('A valid email is required'),
  mobile_no: z.string().optional(),
  password: z.string().min(6, 'Password must be at least 6 characters'),
});

export const loginSchema = z.object({
  email: z.string().email('A valid email is required'),
  password: z.string().min(1, 'Password is required'),
  device_token: z.string().optional(),
});

export const deviceTokenSchema = z.object({
  device_token: z.string().min(1, 'Device token is required'),
});

export const updateProfileSchema = z.object({
  first_name: z.string().optional(),
  last_name: z.string().optional(),
  mobile_no: z.string().optional(),
  gender: z.string().optional(),
  dob: z.string().optional(),
  profile: z.string().optional(),
});

export const updateKycSchema = z.object({
  aadhar_number: z.string().optional(),
  pan_number: z.string().optional(),
  upload_aadhaar: z.string().optional(),
  upload_pan: z.string().optional(),
  account_name: z.string().optional(),
  account_no: z.string().optional(),
  bank_name: z.string().optional(),
  ifcs: z.string().optional(),
  bank_address: z.string().optional(),
});

export const updateBusinessSchema = z.object({
  business_name: z.string().optional(),
  business_type: z.string().optional(),
  business_category: z.string().optional(),
  business_email: z.string().optional(),
});

export const updateAddressSchema = z.object({
  address: z.string().optional(),
  country: z.string().optional(),
  state: z.string().optional(),
  city: z.string().optional(),
  pincode: z.number().int().optional(),
});
