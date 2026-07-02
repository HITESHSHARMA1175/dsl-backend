import { PrismaClient } from '@prisma/client';

export class CommonService {
  constructor(private prisma: PrismaClient) {}

  async getCountries() {
    return (this.prisma as any).countries.findMany({ orderBy: { name: 'asc' } });
  }

  async getStates(countryId: number) {
    return (this.prisma as any).states.findMany({
      where: { country_id: countryId },
      orderBy: { name: 'asc' },
    });
  }

  async getCities(stateId: number) {
    return (this.prisma as any).cities.findMany({
      where: { state_id: stateId },
      orderBy: { name: 'asc' },
    });
  }

  /**
   * Generic master-value lookup by the master head name
   * (e.g. "Appointment Type", "Treatment Type", "Business Type").
   */
  async getMasterValuesByHead(headName: string) {
    const master = await (this.prisma as any).masters.findFirst({
      where: { MasterHead: headName },
    });
    if (!master) {
      return [];
    }
    return (this.prisma as any).masterValue.findMany({
      where: { MasterHead: Number(master.id), status: 1 },
      orderBy: { id: 'asc' },
    });
  }

  async getStaff() {
    return (this.prisma as any).user.findMany({
      where: { emp_type: 'Staff', status: 1 },
      orderBy: { id: 'desc' },
    });
  }

  async getTreatments() {
    return (this.prisma as any).treatment.findMany({
      where: { status: 1 },
      orderBy: { id: 'desc' },
    });
  }

  async getRooms() {
    return (this.prisma as any).property_rooms.findMany({
      orderBy: { id: 'desc' },
    });
  }

  async getStaticPage(slug: string) {
    return (this.prisma as any).seo.findFirst({
      where: { pageurl: slug },
    });
  }

  /** Storefront search across active services/properties. */
  async search(query: string) {
    if (!query) return [];
    // Use a raw query with explicit columns to avoid invalid zero-date
    // values in `created_at` that break Prisma's default column selection.
    return (this.prisma as any).$queryRawUnsafe(
      `SELECT id, property_name, description, price, discounted_price, duration, profile, status
       FROM properties
       WHERE status = 1 AND property_name LIKE ?
       ORDER BY id DESC
       LIMIT 50`,
      `%${query}%`
    );
  }
}
