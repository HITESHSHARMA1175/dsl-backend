/**
 * Newsletter / consultation subscription management.
 * Maps to the `subscribe_forms` table.
 */
export class SubscribeService {
  constructor(private prisma: any) {}

  async create(data: any) {
    return this.prisma.subscribe_forms.create({
      data: {
        full_name: data.full_name || null,
        email: data.email,
        selectedTreatments: data.selectedTreatments ?? null,
      },
    });
  }

  async list(page = 1, perPage = 10) {
    const [items, total] = await Promise.all([
      this.prisma.subscribe_forms.findMany({
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.subscribe_forms.count(),
    ]);
    return { items, total };
  }
}
