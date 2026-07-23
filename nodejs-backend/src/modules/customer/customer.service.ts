import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

export class CustomerService {
  constructor(private prisma: PrismaClient) {}

  private formatCustomer(customer: any) {
    if (!customer) return customer;
    const { password, ...rest } = customer;
    return {
      ...rest,
      id: Number(customer.id),
    };
  }

  async getProfile(customerId: number) {
    const customer = await this.prisma.customer.findUnique({
      where: { id: customerId },
    });
    if (!customer) {
      throw new AppError(404, 'Customer not found');
    }
    return this.formatCustomer(customer);
  }

  async updateProfile(customerId: number, data: {
    first_name?: string;
    last_name?: string;
    mobile?: string;
    dob?: string;
    gender?: string;
    email?: string;
  }) {
    // If email is being updated, check uniqueness excluding self
    if (data.email) {
      const existing = await this.prisma.customer.findFirst({
        where: {
          email: data.email,
          id: { not: customerId },
        },
      });
      if (existing) {
        throw new AppError(409, 'Email is already in use');
      }
    }

    const updated = await this.prisma.customer.update({
      where: { id: customerId },
      data,
    });
    return this.formatCustomer(updated);
  }

  async listAddresses(customerId: number) {
    const addresses = await this.prisma.customerAddress.findMany({
      where: { user_id: String(customerId) },
    });
    return addresses.map((a: any) => ({ ...a, id: Number(a.id) }));
  }

  async createAddress(customerId: number, data: {
    address_type: string;
    country: string;
    state: string;
    city: string;
    address: string;
    pincode?: string;
  }) {
    const created = await this.prisma.customerAddress.create({
      data: {
        user_id: String(customerId),
        ...data,
      },
    });
    return { ...created, id: Number(created.id) };
  }

  async updateAddress(customerId: number, addressId: number, data: {
    address_type?: string;
    country?: string;
    state?: string;
    city?: string;
    address?: string;
    pincode?: string;
  }) {
    // Verify ownership
    const address = await this.prisma.customerAddress.findUnique({
      where: { id: addressId },
    });
    if (!address || address.user_id !== String(customerId)) {
      throw new AppError(404, 'Address not found');
    }

    const updated = await this.prisma.customerAddress.update({
      where: { id: addressId },
      data,
    });
    return { ...updated, id: Number(updated.id) };
  }

  async getBookingHistory(customerId: number) {
    return this.prisma.kiBooking.findMany({
      where: { user_id: customerId },
    });
  }

  async getOrderHistory(customerId: number) {
    return this.prisma.order.findMany({
      where: { user_id: customerId },
    });
  }

  async getEmiList(customerId: number) {
    return (this.prisma as any).customer_emis.findMany({
      where: { customer_id: customerId },
      orderBy: { id: 'desc' },
    });
  }

  async addEmi(customerId: number, data: {
    emi_amount: number;
    emi_start_date?: string;
    emi_end_date?: string;
    payment_status?: string;
  }) {
    return (this.prisma as any).customer_emis.create({
      data: {
        customer_id: customerId,
        emi_amount: data.emi_amount,
        emi_start_date: data.emi_start_date ? new Date(data.emi_start_date) : null,
        emi_end_date: data.emi_end_date ? new Date(data.emi_end_date) : null,
        payment_status: data.payment_status || 'Pending',
        status: 1,
      },
    });
  }

  async getBuyerList(page = 1, perPage = 10, search?: string) {
    const where: any = {};
    if (search) {
      where.OR = [
        { first_name: { contains: search } },
        { last_name: { contains: search } },
        { email: { contains: search } },
        { mobile: { contains: search } },
      ];
    }
    const [items, total] = await Promise.all([
      (this.prisma as any).customer.findMany({
        where,
        skip: (page - 1) * perPage,
        take: perPage,
        orderBy: { id: 'desc' },
      }),
      (this.prisma as any).customer.count({ where }),
    ]);
    return { items: (items as any[]).map((i: any) => this.formatCustomer(i)), total };
  }
}
