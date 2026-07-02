import { prisma } from '../../config/database';

export class ConsultationFormService {
  async list() {
    return (prisma as any).consultation_forms.findMany({ orderBy: { id: 'desc' } });
  }

  async getById(id: number) {
    return (prisma as any).consultation_forms.findUnique({ where: { id } });
  }

  async getReferrals() {
    return (prisma as any).consultation_forms.findMany({
      where: { ctype: 'referral' },
      orderBy: { id: 'desc' },
    });
  }

  async getSubscribed() {
    return (prisma as any).subscribe_forms.findMany({ orderBy: { id: 'desc' } });
  }

  /** Public submission of a consultation / contact form. */
  async submit(data: {
    ctype?: string;
    first_name?: string;
    last_name?: string;
    email?: string;
    mobile?: string;
    clinic?: string;
    service?: string;
    message?: string;
  }) {
    return (prisma as any).consultation_forms.create({
      data: {
        ctype: data.ctype || 'consultation',
        first_name: data.first_name || null,
        last_name: data.last_name || null,
        email: data.email || null,
        mobile: data.mobile || null,
        clinic: data.clinic || null,
        service: data.service || null,
        message: data.message || null,
      },
    });
  }
}
