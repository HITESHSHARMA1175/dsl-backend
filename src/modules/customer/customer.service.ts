import { PrismaClient } from '@prisma/client';
import { AppError } from '../../shared/utils/appError';

export class CustomerService {
  constructor(private prisma: PrismaClient) {}

  async getProfile(customerId: number) {
    const customer = await this.prisma.customer.findUnique({
      where: { id: customerId },
    });
    if (!customer) {
      throw new AppError(404, 'Customer not found');
    }
    return customer;
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

    return this.prisma.customer.update({
      where: { id: customerId },
      data,
    });
  }

  async listAddresses(customerId: number) {
    return this.prisma.customerAddress.findMany({
      where: { user_id: customerId },
    });
  }

  async createAddress(customerId: number, data: {
    address_type: string;
    country: string;
    state: string;
    city: string;
    address: string;
    pincode?: string;
  }) {
    return this.prisma.customerAddress.create({
      data: {
        user_id: customerId,
        ...data,
      },
    });
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
    if (!address || address.user_id !== customerId) {
      throw new AppError(404, 'Address not found');
    }

    return this.prisma.customerAddress.update({
      where: { id: addressId },
      data,
    });
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
}
