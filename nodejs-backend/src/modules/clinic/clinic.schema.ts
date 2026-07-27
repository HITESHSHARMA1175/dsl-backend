import { z } from 'zod';

export const createClinicSchema = z.object({
  name: z.string().min(1, 'Clinic Name is required'),
  clinicName: z.string().optional(),
  email: z.string().email('Invalid email format').optional().or(z.literal('')),
  phone: z.string().optional(),
  whatsapp: z.string().optional(),
  altPhone: z.string().optional(),
  website: z.string().optional(),
  timezone: z.string().optional(),
  address: z.string().optional(),
  shortAddress: z.string().optional(),
  googleMap: z.string().optional(),
  metroStationName: z.string().optional(),
  metroStationText: z.string().optional(),
  railwayStationName: z.string().optional(),
  railwayStationText: z.string().optional(),
  monFriOpen: z.boolean().optional(),
  monFriStart: z.string().optional(),
  monFriClose: z.string().optional(),
  satOpen: z.boolean().optional(),
  satStart: z.string().optional(),
  satClose: z.string().optional(),
  sunOpen: z.boolean().optional(),
  sunStart: z.string().optional(),
  sunClose: z.string().optional(),
  closingTime: z.string().optional(),
  profile: z.string().optional(),
  status: z.number().optional(),
  slug: z.string().optional(),
});

export const updateClinicSchema = createClinicSchema.partial();

