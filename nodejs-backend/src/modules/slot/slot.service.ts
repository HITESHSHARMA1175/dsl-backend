import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';
import fs from 'fs';
import path from 'path';

export interface ClinicSlotItem {
  id: string;
  time: string;
  active: boolean;
  sort_order?: number;
}

const DEFAULT_SLOTS: ClinicSlotItem[] = [
  { id: 's1', time: '10:00 AM - 11:00 AM', active: true },
  { id: 's2', time: '11:30 AM - 12:30 PM', active: true },
  { id: 's3', time: '02:00 PM - 03:00 PM', active: true },
  { id: 's4', time: '04:00 PM - 05:00 PM', active: true },
  { id: 's5', time: '05:30 PM - 06:30 PM', active: true },
  { id: 's6', time: '07:00 PM - 08:00 PM', active: true },
];

function parseStartTimeToMinutes(timeStr: string): number {
  if (!timeStr) return 0;
  const match = timeStr.match(/^(\d{1,2}):(\d{2})\s*(AM|PM)/i);
  if (!match) return 0;

  let hour = parseInt(match[1], 10);
  const min = parseInt(match[2], 10);
  const period = match[3].toUpperCase();

  if (period === 'PM' && hour < 12) hour += 12;
  if (period === 'AM' && hour === 12) hour = 0;

  return hour * 60 + min;
}

export class SlotService {
  private ensureTablePromise?: Promise<void>;
  private jsonFilePath = path.join(process.cwd(), 'uploads', 'clinic_slots.json');

  constructor(private prisma: PrismaClient) {}

  private async ensureTable(): Promise<void> {
    if (!this.ensureTablePromise) {
      this.ensureTablePromise = (async () => {
        try {
          await this.prisma.$executeRawUnsafe(`
            CREATE TABLE IF NOT EXISTS clinic_slots (
              id INT UNSIGNED NOT NULL AUTO_INCREMENT,
              slot_key VARCHAR(100) NOT NULL UNIQUE,
              time_range VARCHAR(255) NOT NULL,
              is_active TINYINT NOT NULL DEFAULT 1,
              sort_order INT NOT NULL DEFAULT 0,
              created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (id)
            )
          `);

          const countRes = await this.prisma.$queryRawUnsafe(`SELECT COUNT(*) as count FROM clinic_slots`);
          const count = Number((countRes as any)?.[0]?.count ?? 0);
          if (count === 0) {
            let sort = 1;
            for (const item of DEFAULT_SLOTS) {
              await this.prisma.$executeRawUnsafe(
                `INSERT INTO clinic_slots (slot_key, time_range, is_active, sort_order) VALUES (?, ?, ?, ?)`,
                item.id,
                item.time,
                item.active ? 1 : 0,
                sort++
              );
            }
          }
        } catch (dbErr) {
          console.warn('MySQL table creation for clinic_slots deferred, using JSON fallback:', dbErr);
          this.ensureJsonFile();
        }
      })();
    }
    return this.ensureTablePromise;
  }

  private ensureJsonFile(): ClinicSlotItem[] {
    try {
      const dir = path.dirname(this.jsonFilePath);
      if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
      if (!fs.existsSync(this.jsonFilePath)) {
        fs.writeFileSync(this.jsonFilePath, JSON.stringify(DEFAULT_SLOTS, null, 2));
        return DEFAULT_SLOTS;
      }
      const raw = fs.readFileSync(this.jsonFilePath, 'utf-8');
      return JSON.parse(raw);
    } catch {
      return DEFAULT_SLOTS;
    }
  }

  private saveJsonFile(slots: ClinicSlotItem[]): void {
    try {
      const dir = path.dirname(this.jsonFilePath);
      if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
      fs.writeFileSync(this.jsonFilePath, JSON.stringify(slots, null, 2));
    } catch (e) {
      console.error('Failed to write clinic_slots.json:', e);
    }
  }

  /** GET ALL SLOTS SORTED BY TIME */
  async listSlots(): Promise<ClinicSlotItem[]> {
    await this.ensureTable();
    let slots: ClinicSlotItem[] = [];
    try {
      const rows = await this.prisma.$queryRawUnsafe(`
        SELECT * FROM clinic_slots ORDER BY id ASC
      `);
      if (Array.isArray(rows) && rows.length > 0) {
        slots = (rows as any[]).map(r => ({
          id: String(r.slot_key || r.id),
          time: String(r.time_range),
          active: Number(r.is_active) === 1,
          sort_order: Number(r.sort_order ?? 0)
        }));
      } else {
        slots = this.ensureJsonFile();
      }
    } catch (e) {
      slots = this.ensureJsonFile();
    }

    return slots.sort((a, b) => parseStartTimeToMinutes(a.time) - parseStartTimeToMinutes(b.time));
  }

  /** CREATE NEW SLOT */
  async createSlot(time: string): Promise<ClinicSlotItem> {
    await this.ensureTable();
    const newId = `slot-${Date.now()}`;
    const cleanTime = time.trim();

    try {
      const maxSortRes = await this.prisma.$queryRawUnsafe(`SELECT MAX(sort_order) as max_sort FROM clinic_slots`);
      const nextSort = Number((maxSortRes as any)?.[0]?.max_sort ?? 0) + 1;

      await this.prisma.$executeRawUnsafe(
        `INSERT INTO clinic_slots (slot_key, time_range, is_active, sort_order) VALUES (?, ?, 1, ?)`,
        newId,
        cleanTime,
        nextSort
      );

      const createdItem: ClinicSlotItem = { id: newId, time: cleanTime, active: true, sort_order: nextSort };
      // Sync JSON
      const currentJson = this.ensureJsonFile();
      currentJson.push(createdItem);
      this.saveJsonFile(currentJson);

      return createdItem;
    } catch (e) {
      const currentJson = this.ensureJsonFile();
      const createdItem: ClinicSlotItem = { id: newId, time: cleanTime, active: true, sort_order: currentJson.length + 1 };
      currentJson.push(createdItem);
      this.saveJsonFile(currentJson);
      return createdItem;
    }
  }

  /** TOGGLE SLOT ACTIVE/DISABLED */
  async toggleSlot(id: string): Promise<ClinicSlotItem> {
    await this.ensureTable();
    try {
      let rows: any[] = [];
      try {
        rows = (await this.prisma.$queryRawUnsafe(`SELECT * FROM clinic_slots WHERE slot_key = ?`, id)) as any[];
      } catch {
        rows = [];
      }

      if ((!rows || rows.length === 0) && /^\d+$/.test(id)) {
        try {
          rows = (await this.prisma.$queryRawUnsafe(`SELECT * FROM clinic_slots WHERE id = ?`, Number(id))) as any[];
        } catch {
          rows = [];
        }
      }

      const row = rows?.[0];
      if (row) {
        const newActive = Number(row.is_active) === 1 ? 0 : 1;
        await this.prisma.$executeRawUnsafe(`UPDATE clinic_slots SET is_active = ? WHERE id = ?`, newActive, row.id);
        
        const updatedItem: ClinicSlotItem = {
          id: String(row.slot_key || row.id),
          time: String(row.time_range),
          active: newActive === 1,
          sort_order: Number(row.sort_order ?? 0)
        };

        const jsonList = this.ensureJsonFile();
        const foundIndex = jsonList.findIndex(s => String(s.id) === String(id));
        if (foundIndex !== -1) {
          jsonList[foundIndex].active = newActive === 1;
          this.saveJsonFile(jsonList);
        }

        return updatedItem;
      }
    } catch (e) {
      console.error('Error toggling slot in DB:', e);
    }

    const jsonList = this.ensureJsonFile();
    const target = jsonList.find(s => String(s.id) === String(id));
    if (!target) throw new AppError(404, 'Slot not found');
    target.active = !target.active;
    this.saveJsonFile(jsonList);
    return target;
  }

  /** DELETE SLOT */
  async deleteSlot(id: string): Promise<{ message: string }> {
    await this.ensureTable();
    try {
      await this.prisma.$executeRawUnsafe(`DELETE FROM clinic_slots WHERE slot_key = ?`, id);
      if (/^\d+$/.test(id)) {
        await this.prisma.$executeRawUnsafe(`DELETE FROM clinic_slots WHERE id = ?`, Number(id));
      }
    } catch (e) {
      console.error('Error deleting slot in DB:', e);
    }

    const jsonList = this.ensureJsonFile();
    const updated = jsonList.filter(s => String(s.id) !== String(id));
    this.saveJsonFile(updated);

    return { message: 'Slot deleted successfully' };
  }

  /** BULK REPLACE SLOTS */
  async bulkUpdateSlots(slots: ClinicSlotItem[]): Promise<ClinicSlotItem[]> {
    await this.ensureTable();
    try {
      await this.prisma.$executeRawUnsafe(`TRUNCATE TABLE clinic_slots`);
      let sort = 1;
      for (const item of slots) {
        await this.prisma.$executeRawUnsafe(
          `INSERT INTO clinic_slots (slot_key, time_range, is_active, sort_order) VALUES (?, ?, ?, ?)`,
          item.id || `slot-${Date.now()}-${sort}`,
          item.time,
          item.active ? 1 : 0,
          sort++
        );
      }
    } catch (e) {
      // fallback
    }

    this.saveJsonFile(slots);
    return slots;
  }
}
