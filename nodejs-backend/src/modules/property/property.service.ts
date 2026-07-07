import { AppError } from '../../shared/utils/appError';

/**
 * Property module (legacy co-living / real-estate style endpoints).
 * Operates on `properties`, `property_rooms`, `property_images` and
 * `property_room_inventories`. Room type master values: 27 = Private, 28 = Shared.
 */
export class PropertyService {
  constructor(private prisma: any) {}

  private async derivePrimaryRoom(propertyId: number) {
    const shared = await this.prisma.property_rooms.findFirst({
      where: { property_id: propertyId, room_type: '28' },
    });
    const priv = await this.prisma.property_rooms.findFirst({
      where: { property_id: propertyId, room_type: '27' },
    });

    if (shared?.id) {
      return { property_type_id: '28', property_type: 'Shared Room', price: shared.room_rent_per_month ?? 0 };
    }
    if (priv?.id) {
      return { property_type_id: '27', property_type: 'Private Room', price: priv.room_rent_per_month ?? 0 };
    }
    return { property_type_id: '28', property_type: 'Shared Room', price: 0 };
  }

  async list(page = 1, perPage = 10) {
    const where = { status: 1 };
    const [items, total] = await Promise.all([
      this.prisma.property.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.property.count({ where }),
    ]);

    const data = await Promise.all(
      items.map(async (p: any) => {
        const primary = await this.derivePrimaryRoom(p.id);
        const image = await this.prisma.property_images.findFirst({ where: { property_id: p.id } });
        return {
          id: p.id,
          property_type: primary.property_type,
          property_name: p.property_name ?? '',
          property_image: image?.image ?? '',
          price: primary.price ?? 0,
          is_wishlist: 0,
          rating: 4.5,
          gender_type: 'Men',
        };
      })
    );

    return { items: data, total };
  }

  async getDetails(propertyId: number) {
    const property = await this.prisma.property.findUnique({ where: { id: propertyId } });
    if (!property) {
      throw new AppError(404, 'Property not found');
    }

    const primary = await this.derivePrimaryRoom(propertyId);
    const images = await this.prisma.property_images.findMany({ where: { property_id: propertyId } });
    const inventory = await this.prisma.property_room_inventories.findMany({ where: { property_id: propertyId } });
    const rooms = await this.prisma.property_rooms.findMany({ where: { property_id: propertyId } });

    let totalBed = 0;
    let totalBath = 0;
    for (const room of rooms) {
      if (room.room_type === '27') {
        totalBed += 1;
      } else if (room.room_type === '28') {
        totalBed += Number(room.room_bed) || 0;
      }
      if (room.bathroom === '33') {
        totalBath += 1;
      }
    }

    return {
      id: property.id,
      property_type_id: primary.property_type_id,
      property_type: primary.property_type,
      property_name: property.property_name ?? '',
      price: primary.price ?? 0,
      is_wishlist: 0,
      rating: 4.5,
      total_review: 256,
      gender_type: 'Men',
      total_bed: totalBed,
      total_bath: totalBath,
      about: property.long_description ?? property.description ?? '',
      property_images: images.map((i: any) => ({ id: i.id, image: i.image })),
      property_inventory: inventory,
      property_room: rooms.map((r: any) => ({
        id: r.id,
        room_type_id: r.room_type,
        room_name: r.rooms,
        price: r.room_rent_per_month,
      })),
    };
  }

  async getRooms(propertyId: number) {
    const rooms = await this.prisma.property_rooms.findMany({ where: { property_id: propertyId } });
    return rooms.map((room: any) => {
      let roomBed = '';
      if (room.room_type === '28') {
        roomBed = `${room.room_bed} bed`;
      }
      let bathroom = '';
      if (room.bathroom === '33') bathroom = 'Attached Bathroom';
      else if (room.bathroom === '34') bathroom = 'Common Bathroom';
      let kitchen = '';
      if (room.kitchen === '31') kitchen = 'Attached Kitchen';
      else if (room.kitchen === '32') kitchen = 'Common Kitchen';

      return {
        id: room.id,
        property_id: room.property_id,
        room_type_id: room.room_type,
        room_name: room.rooms,
        price: room.room_rent_per_month,
        room_bed: roomBed,
        bathroom,
        kitchen,
        available: room.available,
      };
    });
  }

  async getRoomBeds(roomId: number) {
    const room = await this.prisma.property_rooms.findUnique({ where: { id: roomId } });
    if (!room) {
      throw new AppError(404, 'Room not found');
    }
    const beds: any[] = [];
    const bedCount = Number(room.room_bed) || 0;
    for (let i = 1; i <= bedCount; i++) {
      beds.push({
        bed_no: i,
        room_id: room.id,
        room_type_id: room.room_type,
        available: room[`available_b${i}`] ?? room.available ?? null,
      });
    }
    return beds;
  }

  // ---------- Admin ----------

  async listAll(page = 1, perPage = 10, search?: string) {
    const where: any = {};
    if (search) {
      where.property_name = { contains: search };
    }
    const [items, total] = await Promise.all([
      this.prisma.property.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      this.prisma.property.count({ where }),
    ]);
    return { items, total };
  }

  async listPropertyRooms(propertyId: number) {
    return this.prisma.property_rooms.findMany({
      where: { property_id: propertyId },
      orderBy: { id: 'desc' },
    });
  }

  async deleteRoom(roomId: number) {
    const room = await this.prisma.property_rooms.findUnique({ where: { id: roomId } });
    if (!room) {
      throw new AppError(404, 'Room not found');
    }
    await this.prisma.property_rooms.delete({ where: { id: roomId } });
    return { message: 'Room deleted successfully' };
  }

  async toggleStatus(id: number) {
    const property = await this.prisma.property.findUnique({ where: { id } });
    if (!property) {
      throw new AppError(404, 'Property not found');
    }
    const newStatus = property.status === 1 ? 0 : 1;
    return this.prisma.property.update({ where: { id }, data: { status: newStatus } });
  }

  async toggleOfferStatus(id: number) {
    const property = await this.prisma.property.findUnique({ where: { id } });
    if (!property) {
      throw new AppError(404, 'Property not found');
    }
    const newStatus = property.offer_status === 1 ? 0 : 1;
    return this.prisma.property.update({ where: { id }, data: { offer_status: newStatus } });
  }
}
