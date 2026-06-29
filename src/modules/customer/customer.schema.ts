import { z } from 'zod';

export const updateProfileSchema = z.object({
  first_name: z.string().optional(),
  last_name: z.string().optional(),
  mobile: z.string().optional(),
  dob: z.string().optional(),
  gender: z.string().optional(),
});

export const createAddressSchema = z.object({
  address_type: z.string().min(1, 'address_type is required'),
  country: z.string().min(1, 'country is required'),
  state: z.string().min(1, 'state is required'),
  city: z.string().min(1, 'city is required'),
  address: z.string().min(1, 'address is required'),
});

export const updateAddressSchema = z.object({
  address_type: z.string().optional(),
  country: z.string().optional(),
  state: z.string().optional(),
  city: z.string().optional(),
  address: z.string().optional(),
  pincode: z.string().optional(),
});
