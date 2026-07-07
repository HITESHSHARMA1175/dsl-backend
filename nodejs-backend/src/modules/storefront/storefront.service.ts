import { SlotService } from '../slot/slot.service';

/**
 * Storefront selection-session module.
 * Mirrors the legacy Laravel server-session booking flow. Selections are keyed
 * by a `system_id` (the client generates/persists this id, equivalent to the
 * old PHP session uuid). Item selections live in `checked_services`; the
 * professional/slot/language/popup state lives in `storefront_sessions`.
 */
export class StorefrontService {
  private slotService: SlotService;

  constructor(private prisma: any) {
    this.slotService = new SlotService(prisma);
  }

  /** Toggle an item (service/addon/product) in the selection session. */
  private async toggleItem(
    systemId: string,
    stype: string,
    sid: number,
    extra: { ssession?: string; sprice?: string; cat_id?: number; item?: number }
  ) {
    const existing = await this.prisma.checked_services.findFirst({
      where: { system_id: systemId, stype, sid },
    });

    if (existing) {
      await this.prisma.checked_services.delete({ where: { id: existing.id } });
      return { action: 'removed', sid };
    }

    await this.prisma.checked_services.create({
      data: {
        system_id: systemId,
        stype,
        sid,
        ssession: extra.ssession ?? null,
        sprice: extra.sprice ?? null,
        cat_id: extra.cat_id ?? null,
        item: extra.item ?? 1,
      },
    });
    return { action: 'added', sid };
  }

  async addRemoveService(systemId: string, sid: number, ssession?: string, sprice?: string, catId?: number) {
    return this.toggleItem(systemId, 'service', sid, { ssession, sprice, cat_id: catId });
  }

  async addRemoveAddon(systemId: string, sid: number, ssession?: string, sprice?: string) {
    return this.toggleItem(systemId, 'addon', sid, { ssession, sprice });
  }

  async addRemoveProduct(systemId: string, sid: number, sprice?: string, item?: number) {
    return this.toggleItem(systemId, 'product', sid, { sprice, item });
  }

  /** Full current selection for a session: services, addons, products + meta. */
  async getSelection(systemId: string) {
    const [services, addons, products, meta] = await Promise.all([
      this.prisma.checked_services.findMany({ where: { system_id: systemId, stype: 'service' } }),
      this.prisma.checked_services.findMany({ where: { system_id: systemId, stype: 'addon' } }),
      this.prisma.checked_services.findMany({ where: { system_id: systemId, stype: 'product' } }),
      this.prisma.storefront_sessions.findUnique({ where: { system_id: systemId } }),
    ]);

    const total =
      [...services, ...addons, ...products].reduce(
        (sum: number, row: any) => sum + (Number(row.sprice) || 0) * (row.item || 1),
        0
      );

    return { services, addons, products, session: meta, total };
  }

  /** Persist professional + addon duration for the session and return slots. */
  async professionalTime(systemId: string, professionalId: number, date?: string, totalServiceDuration?: number) {
    await this.upsertSession(systemId, { professional_id: professionalId });
    let slots: any[] = [];
    if (date && totalServiceDuration) {
      slots = await this.slotService.getAvailableSlots(professionalId, date, totalServiceDuration);
    }
    return { professional_id: professionalId, slots };
  }

  /** Persist the chosen slot to the session. */
  async updateTimeSlot(systemId: string, slotId: number, slotDate: string, slotTime: string) {
    return this.upsertSession(systemId, { slot_id: slotId, slot_date: slotDate, slot_time: slotTime });
  }

  /** Persist arbitrary selection metadata (professional, slot, addon duration). */
  async saveSelectedData(systemId: string, data: any) {
    return this.upsertSession(systemId, {
      professional_id: data.professional_id,
      slot_id: data.slot_id,
      slot_date: data.slot_date,
      slot_time: data.slot_time,
      total_addon_duration: data.total_addon_duration != null ? String(data.total_addon_duration) : undefined,
    });
  }

  async changeLanguage(systemId: string, language: string) {
    return this.upsertSession(systemId, { language });
  }

  async hidePopup(systemId: string) {
    return this.upsertSession(systemId, { hide_popup: 1 });
  }

  /** Clear the entire selection session. */
  async clear(systemId: string) {
    await this.prisma.checked_services.deleteMany({ where: { system_id: systemId } });
    await this.prisma.storefront_sessions.deleteMany({ where: { system_id: systemId } });
    return { message: 'Selection cleared' };
  }

  /** Storefront service search by name (active services only). */
  async searchServices(query: string) {
    if (!query) return [];
    return this.prisma.$queryRawUnsafe(
      `SELECT id, property_name, description, price, discounted_price, duration, profile, status
       FROM properties
       WHERE status = 1 AND property_name LIKE ?
       ORDER BY id DESC
       LIMIT 50`,
      `%${query}%`
    );
  }

  private async upsertSession(systemId: string, data: any) {
    const clean: any = {};
    for (const [k, v] of Object.entries(data)) {
      if (v !== undefined) clean[k] = v;
    }
    return this.prisma.storefront_sessions.upsert({
      where: { system_id: systemId },
      create: { system_id: systemId, ...clean },
      update: clean,
    });
  }
}
