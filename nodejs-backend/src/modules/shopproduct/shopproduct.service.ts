import { AppError } from '../../shared/utils/appError';

export class ShopProductService {
  private ensureTablePromise?: Promise<void>;

  constructor(private prisma: any) {}

  private ensureTable() {
    if (!this.ensureTablePromise) {
      this.ensureTablePromise = this.prisma.$executeRawUnsafe(`
        CREATE TABLE IF NOT EXISTS shop_products (
          id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
          name VARCHAR(255) NOT NULL,
          description TEXT NULL,
          price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
          image VARCHAR(500) NULL,
          category VARCHAR(255) NULL,
          type VARCHAR(50) NOT NULL DEFAULT 'custom',
          shopify_url VARCHAR(500) NULL,
          is_active TINYINT NOT NULL DEFAULT 1,
          sort_order INT NOT NULL DEFAULT 0,
          created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
          updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          PRIMARY KEY (id),
          INDEX shop_products_is_active_sort_order_idx (is_active, sort_order)
        )
      `).then(() => undefined);
    }

    return this.ensureTablePromise;
  }

  /** Public: list all active products ordered by sort_order */
  async listPublic() {
    await this.ensureTable();
    return this.prisma.$queryRawUnsafe(`
      SELECT
        id,
        name,
        description,
        price,
        image,
        category,
        type,
        shopify_url,
        is_active,
        sort_order,
        created_at,
        updated_at
      FROM shop_products
      ORDER BY sort_order ASC, id DESC
    `);
  }

  /** Admin: list all products (active + inactive) with pagination */
  async listAdmin(page = 1, perPage = 20, search?: string) {
    await this.ensureTable();
    const where: any = {};
    if (search) {
      where.name = { contains: search };
    }

    const [items, total] = await Promise.all([
      this.prisma.shop_products.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: [{ sort_order: 'asc' }, { id: 'desc' }],
      }),
      this.prisma.shop_products.count({ where }),
    ]);

    return { items, total };
  }

  /** Admin: get single product */
  async getById(id: number) {
    await this.ensureTable();
    const product = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!product) throw new AppError(404, 'Product not found');
    return product;
  }

  /** Admin: create product */
  async create(data: any) {
    await this.ensureTable();
    return this.prisma.shop_products.create({
      data: {
        name: data.name,
        description: data.description || null,
        price: data.price ?? 0,
        image: data.image || null,
        category: data.category || null,
        type: data.type || 'custom',
        shopify_url: data.shopify_url || null,
        is_active: data.is_active ?? 1,
        sort_order: data.sort_order ?? 0,
      },
    });
  }

  /** Admin: update product */
  async update(id: number, data: any) {
    await this.ensureTable();
    const existing = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!existing) throw new AppError(404, 'Product not found');

    const updateData: any = {};
    if (data.name !== undefined) updateData.name = data.name;
    if (data.description !== undefined) updateData.description = data.description;
    if (data.price !== undefined) updateData.price = data.price;
    if (data.image !== undefined) updateData.image = data.image;
    if (data.category !== undefined) updateData.category = data.category;
    if (data.type !== undefined) updateData.type = data.type;
    if (data.shopify_url !== undefined) updateData.shopify_url = data.shopify_url;
    if (data.is_active !== undefined) updateData.is_active = data.is_active;
    if (data.sort_order !== undefined) updateData.sort_order = data.sort_order;

    return this.prisma.shop_products.update({ where: { id }, data: updateData });
  }

  /** Admin: toggle active/inactive */
  async toggleStatus(id: number) {
    await this.ensureTable();
    const existing = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!existing) throw new AppError(404, 'Product not found');
    return this.prisma.shop_products.update({
      where: { id },
      data: { is_active: existing.is_active === 1 ? 0 : 1 },
    });
  }

  /** Admin: delete product */
  async delete(id: number) {
    await this.ensureTable();
    const existing = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!existing) throw new AppError(404, 'Product not found');
    await this.prisma.shop_products.delete({ where: { id } });
    return { message: 'Product deleted successfully' };
  }
}
