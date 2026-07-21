import { AppError } from '../../shared/utils/appError';

export class ShopProductService {
  constructor(private prisma: any) {}

  /** Public: list all active products ordered by sort_order */
  async listPublic() {
    return this.prisma.shop_products.findMany({
      where: { is_active: 1 },
      orderBy: [{ sort_order: 'asc' }, { id: 'desc' }],
    });
  }

  /** Admin: list all products (active + inactive) with pagination */
  async listAdmin(page = 1, perPage = 20, search?: string) {
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
    const product = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!product) throw new AppError(404, 'Product not found');
    return product;
  }

  /** Admin: create product */
  async create(data: any) {
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
    const existing = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!existing) throw new AppError(404, 'Product not found');
    return this.prisma.shop_products.update({
      where: { id },
      data: { is_active: existing.is_active === 1 ? 0 : 1 },
    });
  }

  /** Admin: delete product */
  async delete(id: number) {
    const existing = await this.prisma.shop_products.findUnique({ where: { id } });
    if (!existing) throw new AppError(404, 'Product not found');
    await this.prisma.shop_products.delete({ where: { id } });
    return { message: 'Product deleted successfully' };
  }
}
