import { AppError } from '../../shared/utils/appError';

const DEFAULT_OFFERS = [
  {
    title: 'Anti-Wrinkle Subscription',
    subtitle: 'Anti-Wrinkle Injections',
    category: 'Cosmetic Injections',
    badges: JSON.stringify(['NEW', 'Featured']),
    price: 45.00,
    was_price: null,
    description: '3 AREAS X 3 TIMES ANNUALLY + £99 SIGN UP FEE',
    button_text: 'Book now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1579684389782-64d84b5e901a?auto=format&fit=crop&q=80&w=600',
    is_featured: 1,
    featured_price_unit: 'PER MONTH',
    featured_subtitle: '3 AREAS X 3 TIMES ANNUALLY + £99 SIGN UP FEE',
    is_active: 1,
    sort_order: 1,
  },
  {
    title: '3 Area Package',
    subtitle: 'Anti-Wrinkle Injections',
    category: 'Cosmetic Injections',
    badges: JSON.stringify(['New Client Offer!', 'Anti-Wrinkle']),
    price: 189.00,
    was_price: 245.00,
    description: 'New Client Offer! Anti-wrinkle injections are administered in precise doses to targeted areas on the face by our doctor-led team.',
    button_text: 'Book now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1579684389782-64d84b5e901a?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 2,
  },
  {
    title: 'Full Body (excluding face)',
    subtitle: 'Laser Hair Removal',
    category: 'Laser Hair Removal',
    badges: JSON.stringify(['Laser Hair Removal']),
    price: 129.95,
    was_price: null,
    description: 'Experience head-to-toe smoothness with our full-body laser hair removal treatment, designed for long-lasting results and effortlessly silky skin.',
    button_text: 'Buy now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 3,
  },
  {
    title: 'Buy 2 Areas, Get 1 FREE',
    subtitle: 'Anti-Wrinkle Injections',
    category: 'Cosmetic Injections',
    badges: JSON.stringify(['3 for 2!', 'Anti-Wrinkle']),
    price: 245.00,
    was_price: 344.00,
    description: 'Administered by our experienced, doctor-led team, anti-wrinkle injections are precisely targeted to refresh and rejuvenate your facial features.',
    button_text: 'Book now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 4,
  },
  {
    title: 'Any Bikini & Underarm',
    subtitle: 'Laser Hair Removal',
    category: 'Laser Hair Removal',
    badges: JSON.stringify(['Laser Hair Removal']),
    price: 29.95,
    was_price: null,
    description: 'Achieve a flawlessly smooth bikini line and underarms with our advanced laser hair removal treatment.',
    button_text: 'Buy now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 5,
  },
  {
    title: 'Dermamelan Depigmentation',
    subtitle: 'Skin Peel Therapy',
    category: 'Skin Treatments',
    badges: JSON.stringify(['Best Seller']),
    price: 599.00,
    was_price: 750.00,
    description: 'Highly effective medical grade peel designed to eliminate stubborn brown spots and pigmentation anomalies.',
    button_text: 'Book now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1608248597481-496100c80836?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 6,
  },
  {
    title: 'Microneedling Face Session',
    subtitle: 'Collagen Induction',
    category: 'Skin Treatments',
    badges: JSON.stringify(['Offer']),
    price: 120.00,
    was_price: 160.00,
    description: 'Promotes skin rejuvenation by triggering collagen synthesis, smoothing out fine lines, wrinkles and acne scars.',
    button_text: 'Book now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 7,
  },
  {
    title: 'Cryolipolysis Fat Freezing',
    subtitle: '3D Lipo Contouring',
    category: 'Body',
    badges: JSON.stringify(['Contouring']),
    price: 299.00,
    was_price: 399.00,
    description: 'Non-surgical alternative to liposuction that targets stubborn fat deposits by cooling them safely.',
    button_text: 'Book now',
    button_link: '',
    image: 'https://images.unsplash.com/photo-1518310383802-640c2de311b2?auto=format&fit=crop&q=80&w=400',
    is_featured: 0,
    featured_price_unit: null,
    featured_subtitle: null,
    is_active: 1,
    sort_order: 8,
  },
];

export class OfferService {
  private ensureTablePromise?: Promise<void>;

  constructor(private prisma: any) {}

  private async ensureTable() {
    if (!this.ensureTablePromise) {
      this.ensureTablePromise = (async () => {
        await this.prisma.$executeRawUnsafe(`
          CREATE TABLE IF NOT EXISTS offers (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255) NULL,
            category VARCHAR(255) NULL,
            badges JSON NULL,
            price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
            was_price DECIMAL(10, 2) NULL,
            description TEXT NULL,
            button_text VARCHAR(100) NULL DEFAULT 'Book now',
            button_link VARCHAR(500) NULL,
            image VARCHAR(500) NULL,
            is_featured TINYINT NOT NULL DEFAULT 0,
            featured_price_unit VARCHAR(100) NULL,
            featured_subtitle VARCHAR(255) NULL,
            is_active TINYINT NOT NULL DEFAULT 1,
            sort_order INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            INDEX offers_is_active_sort_order_idx (is_active, sort_order)
          )
        `);

        // Check if table has rows, if 0, seed defaults
        const countRes = await this.prisma.$queryRawUnsafe(`SELECT COUNT(*) as count FROM offers`);
        const count = Number((countRes as any)?.[0]?.count ?? 0);
        if (count === 0) {
          for (const item of DEFAULT_OFFERS) {
            await this.prisma.$executeRawUnsafe(
              `INSERT INTO offers (title, subtitle, category, badges, price, was_price, description, button_text, button_link, image, is_featured, featured_price_unit, featured_subtitle, is_active, sort_order)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
              item.title,
              item.subtitle,
              item.category,
              item.badges,
              item.price,
              item.was_price,
              item.description,
              item.button_text,
              item.button_link,
              item.image,
              item.is_featured,
              item.featured_price_unit,
              item.featured_subtitle,
              item.is_active,
              item.sort_order
            );
          }
        }
      })();
    }
    return this.ensureTablePromise;
  }

  private normalizeBadges(badges: any): string[] {
    if (!badges) return [];
    if (Array.isArray(badges)) return badges;
    if (typeof badges === 'string') {
      try {
        const parsed = JSON.parse(badges);
        return Array.isArray(parsed) ? parsed : [badges];
      } catch {
        return badges.split(',').map(s => s.trim()).filter(Boolean);
      }
    }
    return [];
  }

  private formatOffer(offer: any) {
    if (!offer) return offer;
    return {
      ...offer,
      id: Number(offer.id),
      price: offer.price !== null && offer.price !== undefined ? Number(offer.price) : 0,
      was_price: offer.was_price !== null && offer.was_price !== undefined ? Number(offer.was_price) : null,
      is_featured: Number(offer.is_featured ?? 0),
      is_active: Number(offer.is_active ?? 1),
      sort_order: Number(offer.sort_order ?? 0),
      badges: this.normalizeBadges(offer.badges),
    };
  }

  /** Public: List active offers */
  async listPublic() {
    await this.ensureTable();
    const offers = await this.prisma.$queryRawUnsafe(`
      SELECT * FROM offers
      WHERE is_active = 1
      ORDER BY sort_order ASC, id DESC
    `);
    return (offers as any[]).map(o => this.formatOffer(o));
  }

  /** Admin: List all offers with pagination & search */
  async listAdmin(page = 1, perPage = 20, search?: string) {
    await this.ensureTable();
    let whereClause = '';
    const params: any[] = [];
    if (search) {
      whereClause = 'WHERE title LIKE ? OR category LIKE ?';
      params.push(`%${search}%`, `%${search}%`);
    }

    const countSql = `SELECT COUNT(*) as count FROM offers ${whereClause}`;
    const countRes = await this.prisma.$queryRawUnsafe(countSql, ...params);
    const total = Number((countRes as any)?.[0]?.count ?? 0);

    const offset = (page - 1) * perPage;
    const itemsSql = `SELECT * FROM offers ${whereClause} ORDER BY sort_order ASC, id DESC LIMIT ? OFFSET ?`;
    const items = await this.prisma.$queryRawUnsafe(itemsSql, ...params, perPage, offset);

    return {
      items: (items as any[]).map(o => this.formatOffer(o)),
      total,
    };
  }

  /** Get single offer by ID */
  async getById(id: number) {
    await this.ensureTable();
    const rows = await this.prisma.$queryRawUnsafe(`SELECT * FROM offers WHERE id = ?`, id);
    const offer = (rows as any[])?.[0];
    if (!offer) throw new AppError(404, 'Offer not found');
    return this.formatOffer(offer);
  }

  /** Admin: Create offer */
  async create(data: any) {
    await this.ensureTable();
    const badgesJson = Array.isArray(data.badges) ? JSON.stringify(data.badges) : (data.badges ? JSON.stringify([data.badges]) : null);
    const res = await this.prisma.$executeRawUnsafe(
      `INSERT INTO offers (title, subtitle, category, badges, price, was_price, description, button_text, button_link, image, is_featured, featured_price_unit, featured_subtitle, is_active, sort_order)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
      data.title,
      data.subtitle || null,
      data.category || null,
      badgesJson,
      data.price ?? 0,
      data.was_price ?? null,
      data.description || null,
      data.button_text || 'Book now',
      data.button_link || null,
      data.image || null,
      data.is_featured ?? 0,
      data.featured_price_unit || null,
      data.featured_subtitle || null,
      data.is_active ?? 1,
      data.sort_order ?? 0
    );

    const createdRows = await this.prisma.$queryRawUnsafe(`SELECT * FROM offers ORDER BY id DESC LIMIT 1`);
    return this.formatOffer((createdRows as any[])?.[0]);
  }

  /** Admin: Update offer */
  async update(id: number, data: any) {
    await this.ensureTable();
    const existing = await this.getById(id);

    const badgesJson = data.badges !== undefined
      ? (Array.isArray(data.badges) ? JSON.stringify(data.badges) : (data.badges ? JSON.stringify([data.badges]) : null))
      : (existing.badges ? JSON.stringify(existing.badges) : null);

    await this.prisma.$executeRawUnsafe(
      `UPDATE offers SET
        title = ?,
        subtitle = ?,
        category = ?,
        badges = ?,
        price = ?,
        was_price = ?,
        description = ?,
        button_text = ?,
        button_link = ?,
        image = ?,
        is_featured = ?,
        featured_price_unit = ?,
        featured_subtitle = ?,
        is_active = ?,
        sort_order = ?
       WHERE id = ?`,
      data.title !== undefined ? data.title : existing.title,
      data.subtitle !== undefined ? data.subtitle : existing.subtitle,
      data.category !== undefined ? data.category : existing.category,
      badgesJson,
      data.price !== undefined ? data.price : existing.price,
      data.was_price !== undefined ? data.was_price : existing.was_price,
      data.description !== undefined ? data.description : existing.description,
      data.button_text !== undefined ? data.button_text : existing.button_text,
      data.button_link !== undefined ? data.button_link : existing.button_link,
      data.image !== undefined ? data.image : existing.image,
      data.is_featured !== undefined ? data.is_featured : existing.is_featured,
      data.featured_price_unit !== undefined ? data.featured_price_unit : existing.featured_price_unit,
      data.featured_subtitle !== undefined ? data.featured_subtitle : existing.featured_subtitle,
      data.is_active !== undefined ? data.is_active : existing.is_active,
      data.sort_order !== undefined ? data.sort_order : existing.sort_order,
      id
    );

    return this.getById(id);
  }

  /** Admin: Toggle active status */
  async toggleStatus(id: number) {
    await this.ensureTable();
    const existing = await this.getById(id);
    const newStatus = existing.is_active === 1 ? 0 : 1;
    await this.prisma.$executeRawUnsafe(`UPDATE offers SET is_active = ? WHERE id = ?`, newStatus, id);
    return this.getById(id);
  }

  /** Admin: Delete offer */
  async delete(id: number) {
    await this.ensureTable();
    await this.getById(id);
    await this.prisma.$executeRawUnsafe(`DELETE FROM offers WHERE id = ?`, id);
    return { message: 'Offer deleted successfully' };
  }
}
