import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

export interface ClinicInputData {
  name: string;
  clinicName?: string;
  email?: string;
  phone?: string;
  whatsapp?: string;
  altPhone?: string;
  website?: string;
  timezone?: string;
  address?: string;
  shortAddress?: string;
  googleMap?: string;
  metroStationName?: string;
  metroStationText?: string;
  railwayStationName?: string;
  railwayStationText?: string;
  monFriOpen?: boolean;
  monFriStart?: string;
  monFriClose?: string;
  satOpen?: boolean;
  satStart?: string;
  satClose?: string;
  sunOpen?: boolean;
  sunStart?: string;
  sunClose?: string;
  closingTime?: string;
  profile?: string;
  status?: number;
  slug?: string;
}

const DEFAULT_CLINICS = [
  {
    id: 1,
    slug: 'wembley',
    name: 'Wembley',
    clinicName: 'DSL Clinic, Wembley',
    address: '348 High Road Wembley HA9 6AZ',
    shortAddress: '348 High Rd, Wembley HA9 6AZ, UK',
    phone: '02080040277',
    email: 'wembley@dslclinic.com',
    website: 'https://dslclinic.com',
    whatsapp: '02080040277',
    altPhone: '',
    timezone: 'GMT',
    closingTime: 'Closes at 7:00 PM',
    mapQuery: '348 High Road Wembley HA9 6AZ',
    googleMap: '348 High Road Wembley HA9 6AZ',
    metroStationName: 'Wembley Central',
    metroStationText: '5 mins walk',
    railwayStationName: 'Wembley Central Station',
    railwayStationText: '5 mins walk',
    profile: '',
    image: '',
    enabled: true,
    status: 1,
    monFri: '10:00 AM - 07:00 PM',
    sat: '10:00 AM - 06:00 PM',
    sun: '10:00 AM - 05:00 PM',
    monFriOpen: true,
    monFriStart: '10:00',
    monFriClose: '19:00',
    satOpen: true,
    satStart: '10:00',
    satClose: '18:00',
    sunOpen: true,
    sunStart: '10:00',
    sunClose: '17:00',
    openingTimes: [
      { days: 'Mon - Fri', hours: '10:00 AM - 07:00 PM' },
      { days: 'Saturday', hours: '10:00 AM - 06:00 PM' },
      { days: 'Sunday', hours: '10:00 AM - 05:00 PM' },
    ],
  },
  {
    id: 2,
    slug: 'harley-street',
    name: 'Harley Street',
    clinicName: 'DSL Clinic, Harley Street',
    address: '102 Harley Street W1G 7JB',
    shortAddress: '102 Harley St, London W1G 7JB, UK',
    phone: '02080040277',
    email: 'harleystreet@dslclinic.com',
    website: 'https://dslclinic.com',
    whatsapp: '02080040277',
    altPhone: '',
    timezone: 'GMT',
    closingTime: 'Closes at 7:00 PM',
    mapQuery: '102 Harley Street W1G 7JB',
    googleMap: '102 Harley Street W1G 7JB',
    metroStationName: 'Oxford Circus',
    metroStationText: '7 mins walk',
    railwayStationName: 'Marylebone Station',
    railwayStationText: '10 mins walk',
    profile: '',
    image: '',
    enabled: true,
    status: 1,
    monFri: '10:00 AM - 07:00 PM',
    sat: '10:00 AM - 06:00 PM',
    sun: '10:00 AM - 05:00 PM',
    monFriOpen: true,
    monFriStart: '10:00',
    monFriClose: '19:00',
    satOpen: true,
    satStart: '10:00',
    satClose: '18:00',
    sunOpen: true,
    sunStart: '10:00',
    sunClose: '17:00',
    openingTimes: [
      { days: 'Mon - Fri', hours: '10:00 AM - 07:00 PM' },
      { days: 'Saturday', hours: '10:00 AM - 06:00 PM' },
      { days: 'Sunday', hours: '10:00 AM - 05:00 PM' },
    ],
  },
  {
    id: 3,
    slug: 'north-kensington',
    name: 'North Kensington',
    clinicName: 'DSL Clinic, North Kensington',
    address: '758 Harrow Road North Kensington NW10 5LE',
    shortAddress: '758 Harrow Rd, London NW10 5LE, UK',
    phone: '02080040277',
    email: 'kensington@dslclinic.com',
    website: 'https://dslclinic.com',
    whatsapp: '02080040277',
    altPhone: '',
    timezone: 'GMT',
    closingTime: 'Closes at 7:00 PM',
    mapQuery: '758 Harrow Road North Kensington NW10 5LE',
    googleMap: '758 Harrow Road North Kensington NW10 5LE',
    metroStationName: 'Kensal Green',
    metroStationText: '4 mins walk',
    railwayStationName: 'Kensal Rise',
    railwayStationText: '6 mins walk',
    profile: '',
    image: '',
    enabled: true,
    status: 1,
    monFri: '10:00 AM - 07:00 PM',
    sat: '10:00 AM - 06:00 PM',
    sun: '10:00 AM - 05:00 PM',
    monFriOpen: true,
    monFriStart: '10:00',
    monFriClose: '19:00',
    satOpen: true,
    satStart: '10:00',
    satClose: '18:00',
    sunOpen: true,
    sunStart: '10:00',
    sunClose: '17:00',
    openingTimes: [
      { days: 'Mon - Fri', hours: '10:00 AM - 07:00 PM' },
      { days: 'Saturday', hours: '10:00 AM - 06:00 PM' },
      { days: 'Sunday', hours: '10:00 AM - 05:00 PM' },
    ],
  },
  {
    id: 4,
    slug: 'knightsbridge',
    name: 'Knightsbridge',
    clinicName: 'DSL Clinic, Knightsbridge',
    address: '20 Beauchamp Place Knightsbridge SW3 1NQ',
    shortAddress: '20 Beauchamp Pl, London SW3 1NQ, UK',
    phone: '02080040277',
    email: 'knightsbridge@dslclinic.com',
    website: 'https://dslclinic.com',
    whatsapp: '02080040277',
    altPhone: '',
    timezone: 'GMT',
    closingTime: 'Closes at 7:00 PM',
    mapQuery: '20 Beauchamp Place Knightsbridge SW3 1NQ',
    googleMap: '20 Beauchamp Place Knightsbridge SW3 1NQ',
    metroStationName: 'Knightsbridge Station',
    metroStationText: '5 mins walk',
    railwayStationName: 'Victoria Station',
    railwayStationText: '12 mins walk',
    profile: '',
    image: '',
    enabled: true,
    status: 1,
    monFri: '10:00 AM - 07:00 PM',
    sat: '10:00 AM - 06:00 PM',
    sun: '10:00 AM - 05:00 PM',
    monFriOpen: true,
    monFriStart: '10:00',
    monFriClose: '19:00',
    satOpen: true,
    satStart: '10:00',
    satClose: '18:00',
    sunOpen: true,
    sunStart: '10:00',
    sunClose: '17:00',
    openingTimes: [
      { days: 'Mon - Fri', hours: '10:00 AM - 07:00 PM' },
      { days: 'Saturday', hours: '10:00 AM - 06:00 PM' },
      { days: 'Sunday', hours: '10:00 AM - 05:00 PM' },
    ],
  },
  {
    id: 5,
    slug: 'barnet-clinic',
    name: 'Barnet Clinic',
    clinicName: 'DSL Clinic, Barnet',
    address: '1345 High Street, London',
    shortAddress: '1345 High St, London, UK',
    phone: '02080040277',
    email: 'barnet@dslclinic.com',
    website: 'https://dslclinic.com',
    whatsapp: '02080040277',
    altPhone: '',
    timezone: 'GMT',
    closingTime: 'Closes at 7:00 PM',
    mapQuery: '1345 High Street London',
    googleMap: '1345 High Street London',
    metroStationName: 'High Barnet',
    metroStationText: '6 mins walk',
    railwayStationName: 'New Barnet',
    railwayStationText: '10 mins walk',
    profile: '',
    image: '',
    enabled: true,
    status: 1,
    monFri: '10:00 AM - 07:00 PM',
    sat: '10:00 AM - 06:00 PM',
    sun: '10:00 AM - 05:00 PM',
    monFriOpen: true,
    monFriStart: '10:00',
    monFriClose: '19:00',
    satOpen: true,
    satStart: '10:00',
    satClose: '18:00',
    sunOpen: true,
    sunStart: '10:00',
    sunClose: '17:00',
    openingTimes: [
      { days: 'Mon - Fri', hours: '10:00 AM - 07:00 PM' },
      { days: 'Saturday', hours: '10:00 AM - 06:00 PM' },
      { days: 'Sunday', hours: '10:00 AM - 05:00 PM' },
    ],
  },
];

let MEMORY_CLINICS: any[] = [...DEFAULT_CLINICS];

function slugify(text: string): string {
  return text
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

export class ClinicService {
  constructor(private prisma: PrismaClient) {}

  private formatClinic(c: any) {
    const rawName = c.clinic_name || c.name || 'DSL Clinic';
    const cleanName = rawName.replace(/^DSL Clinic,?\s*/i, '') || rawName;
    const fullClinicName = c.clinic_name || `DSL Clinic, ${cleanName}`;
    const slug = c.slug || slugify(cleanName) || `clinic-${c.id}`;

    const monFri = c.mon_to_fry || '10:00 AM - 07:00 PM';
    const sat = c.sat || '10:00 AM - 06:00 PM';
    const sun = c.sun || '10:00 AM - 05:00 PM';

    const profilePic = c.profile || '';
    let image = '';
    if (profilePic) {
      image = profilePic.startsWith('http') || profilePic.startsWith('data:')
        ? profilePic
        : `/uploads/${profilePic.replace(/^\/+uploads\//, '')}`;
    }

    const mapQuery = c.google_map || c.address || cleanName;

    return {
      id: Number(c.id),
      slug,
      name: cleanName,
      clinicName: fullClinicName,
      address: c.address || '',
      shortAddress: c.short_address || c.address || '',
      phone: c.clinic_phone || c.phone || '02080040277',
      email: c.clinic_email || c.email || '',
      website: c.clinic_website || c.website || '',
      whatsapp: c.clinic_whatsapp || c.whatsapp || '',
      altPhone: c.clinic_alt_phone || c.altPhone || '',
      timezone: c.clinic_timezone || c.timezone || 'GMT',
      googleMap: c.google_map || '',
      mapQuery,
      metroStationName: c.metro_name || c.metroStationName || '',
      metroStationText: c.metro_text || c.metroStationText || '',
      railwayStationName: c.railway_name || c.railwayStationName || '',
      railwayStationText: c.railway_text || c.railwayStationText || '',
      profile: profilePic,
      image,
      enabled: c.status !== 0,
      status: c.status ?? 1,
      monFri,
      sat,
      sun,
      monFriOpen: c.mon_to_fry !== 'Closed',
      monFriStart: c.mon_fri_start || '10:00',
      monFriClose: c.mon_fri_close || '19:00',
      satOpen: c.sat !== 'Closed',
      satStart: c.sat_start || '10:00',
      satClose: c.sat_close || '18:00',
      sunOpen: c.sun !== 'Closed',
      sunStart: c.sun_start || '10:00',
      sunClose: c.sun_close || '17:00',
      closingTime: c.closing_time || 'Closes at 7:00 PM',
      openingTimes: [
        { days: 'Mon - Fri', hours: monFri },
        { days: 'Saturday', hours: sat },
        { days: 'Sunday', hours: sun },
      ],
      created_at: c.created_at,
      updated_at: c.updated_at,
    };
  }

  async list() {
    try {
      const records = await this.prisma.clinic.findMany({
        orderBy: { id: 'asc' },
      });

      const formattedDb = Array.isArray(records) ? records.map((r) => this.formatClinic(r)) : [];

      const dbIds = new Set(formattedDb.map((item) => item.id));
      const dbSlugs = new Set(formattedDb.map((item) => item.slug));

      const extraMemory = MEMORY_CLINICS.filter(
        (m) => !dbIds.has(m.id) && !dbSlugs.has(m.slug)
      );

      const combined = [...formattedDb, ...extraMemory];
      return combined.length > 0 ? combined : MEMORY_CLINICS;
    } catch (err) {
      console.warn('Clinic list fallback to memory store:', err);
      return MEMORY_CLINICS;
    }
  }

  async getPublicClinics() {
    const all = await this.list();
    return all.filter((c) => c.enabled);
  }

  async getPublicClinicBySlugOrId(slugOrId: string) {
    const all = await this.list();
    const found = all.find(
      (c) =>
        c.slug === slugOrId ||
        c.id === Number(slugOrId) ||
        c.name.toLowerCase() === slugOrId.toLowerCase()
    );

    if (!found) {
      return all[0] || MEMORY_CLINICS[0];
    }
    return found;
  }

  async getById(id: number) {
    const all = await this.list();
    const found = all.find((c) => c.id === Number(id));
    if (found) return found;
    throw new AppError(404, 'Clinic not found');
  }

  async create(data: ClinicInputData) {
    const clinicName = data.clinicName || (data.name.startsWith('DSL Clinic') ? data.name : `DSL Clinic, ${data.name}`);
    const name = data.name;
    const slug = data.slug || slugify(name);

    const monFri = data.monFriOpen === false ? 'Closed' : (data.monFriStart && data.monFriClose ? `${data.monFriStart} - ${data.monFriClose}` : '10:00 AM - 07:00 PM');
    const sat = data.satOpen === false ? 'Closed' : (data.satStart && data.satClose ? `${data.satStart} - ${data.satClose}` : '10:00 AM - 06:00 PM');
    const sun = data.sunOpen === false ? 'Closed' : (data.sunStart && data.sunClose ? `${data.sunStart} - ${data.sunClose}` : '10:00 AM - 05:00 PM');

    let createdFormatted: any = null;

    try {
      const record = await this.prisma.clinic.create({
        data: {
          clinic_name: clinicName,
          address: data.address || '',
          clinic_phone: data.phone || '',
          clinic_email: data.email || '',
          clinic_website: data.website || '',
          clinic_whatsapp: data.whatsapp || '',
          clinic_alt_phone: data.altPhone || '',
          clinic_timezone: data.timezone || 'GMT',
          google_map: data.googleMap || data.address || name,
          metro_name: data.metroStationName || '',
          metro_text: data.metroStationText || '',
          railway_name: data.railwayStationName || '',
          railway_text: data.railwayStationText || '',
          mon_to_fry: monFri,
          sat: sat,
          sun: sun,
          profile: data.profile || '',
        },
      });

      createdFormatted = this.formatClinic(record);
    } catch (err: any) {
      console.error('Error creating clinic in DB:', err);
      createdFormatted = this.formatClinic({
        id: Date.now(),
        clinic_name: clinicName,
        name,
        slug,
        address: data.address,
        clinic_phone: data.phone,
        clinic_email: data.email,
        clinic_website: data.website,
        clinic_whatsapp: data.whatsapp,
        clinic_alt_phone: data.altPhone,
        clinic_timezone: data.timezone,
        google_map: data.googleMap,
        metro_name: data.metroStationName,
        metro_text: data.metroStationText,
        railway_name: data.railwayStationName,
        railway_text: data.railwayStationText,
        mon_to_fry: monFri,
        sat: sat,
        sun: sun,
        profile: data.profile,
        status: data.status ?? 1,
      });
    }

    if (createdFormatted) {
      const existingIdx = MEMORY_CLINICS.findIndex((c) => c.id === createdFormatted.id || c.slug === createdFormatted.slug);
      if (existingIdx !== -1) {
        MEMORY_CLINICS[existingIdx] = createdFormatted;
      } else {
        MEMORY_CLINICS.push(createdFormatted);
      }
    }

    return createdFormatted;
  }

  async update(id: number, data: Partial<ClinicInputData>) {
    const memIdx = MEMORY_CLINICS.findIndex((c) => c.id === Number(id));
    if (memIdx !== -1) {
      const target = MEMORY_CLINICS[memIdx];
      if (data.name) {
        target.name = data.name.replace(/^DSL Clinic,?\s*/i, '');
        target.clinicName = data.clinicName || `DSL Clinic, ${target.name}`;
      }
      if (data.address !== undefined) target.address = data.address;
      if (data.phone !== undefined) target.phone = data.phone;
      if (data.email !== undefined) target.email = data.email;
      if (data.website !== undefined) target.website = data.website;
      if (data.whatsapp !== undefined) target.whatsapp = data.whatsapp;
      if (data.altPhone !== undefined) target.altPhone = data.altPhone;
      if (data.timezone !== undefined) target.timezone = data.timezone;
      if (data.googleMap !== undefined) target.googleMap = data.googleMap;
      if (data.metroStationName !== undefined) target.metroStationName = data.metroStationName;
      if (data.metroStationText !== undefined) target.metroStationText = data.metroStationText;
      if (data.railwayStationName !== undefined) target.railwayStationName = data.railwayStationName;
      if (data.railwayStationText !== undefined) target.railwayStationText = data.railwayStationText;
      if (data.profile !== undefined) target.profile = data.profile;
      MEMORY_CLINICS[memIdx] = target;
    }

    try {
      const existing = await this.prisma.clinic.findUnique({ where: { id } });
      if (existing) {
        const updatePayload: any = {};
        if (data.name || data.clinicName) {
          updatePayload.clinic_name = data.clinicName || (data.name ? (data.name.startsWith('DSL Clinic') ? data.name : `DSL Clinic, ${data.name}`) : existing.clinic_name);
        }
        if (data.address !== undefined) updatePayload.address = data.address;
        if (data.phone !== undefined) updatePayload.clinic_phone = data.phone;
        if (data.email !== undefined) updatePayload.clinic_email = data.email;
        if (data.website !== undefined) updatePayload.clinic_website = data.website;
        if (data.whatsapp !== undefined) updatePayload.clinic_whatsapp = data.whatsapp;
        if (data.altPhone !== undefined) updatePayload.clinic_alt_phone = data.altPhone;
        if (data.timezone !== undefined) updatePayload.clinic_timezone = data.timezone;
        if (data.googleMap !== undefined) updatePayload.google_map = data.googleMap;
        if (data.metroStationName !== undefined) updatePayload.metro_name = data.metroStationName;
        if (data.metroStationText !== undefined) updatePayload.metro_text = data.metroStationText;
        if (data.railwayStationName !== undefined) updatePayload.railway_name = data.railwayStationName;
        if (data.railwayStationText !== undefined) updatePayload.railway_text = data.railwayStationText;
        if (data.profile !== undefined) updatePayload.profile = data.profile;

        const updated = await this.prisma.clinic.update({
          where: { id },
          data: updatePayload,
        });
        return this.formatClinic(updated);
      }
    } catch (err: any) {
      console.warn('Prisma update clinic fallback:', err);
    }

    return MEMORY_CLINICS.find((c) => c.id === Number(id)) || DEFAULT_CLINICS[0];
  }

  async delete(id: number) {
    MEMORY_CLINICS = MEMORY_CLINICS.filter((c) => c.id !== Number(id));
    try {
      await this.prisma.clinic.delete({ where: { id } });
    } catch (err) {
      console.warn('Prisma delete clinic fallback:', err);
    }
    return { message: 'Clinic deleted successfully' };
  }

  async toggleStatus(id: number) {
    const memItem = MEMORY_CLINICS.find((c) => c.id === Number(id));
    if (memItem) {
      memItem.enabled = !memItem.enabled;
      memItem.status = memItem.enabled ? 1 : 0;
      return memItem;
    }
    return { message: 'Status toggled' };
  }

  // ==================== MOBILE (clinic detail) ENDPOINTS ====================

  async getInfo(id: number) {
    const clinic = await this.getById(id);
    return clinic;
  }

  async getHxg(id: number) {
    const clinic = await this.getById(id);
    if (!clinic) return null;
    return {
      id: clinic.id,
      clinic_name: clinic.clinicName,
      profile: clinic.profile,
      address: clinic.address,
      google_map: clinic.googleMap,
      metro_name: clinic.metroStationName,
      metro_text: clinic.metroStationText,
      railway_name: clinic.railwayStationName,
      railway_text: clinic.railwayStationText,
    };
  }
}
