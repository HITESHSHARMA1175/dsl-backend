import { Request, Response, NextFunction } from 'express';
import { BookingService } from './booking.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const bookingService = new BookingService(prisma);

export async function createBooking(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await bookingService.create(req.body);
    return res.status(200).json(successResponse(200, 'Booking created successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function listBookings(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);

    const { items, total } = await bookingService.list(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;

    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function searchBookings(req: Request, res: Response, next: NextFunction) {
  try {
    const searchText = (req.query.search_text as string) || '';
    const items = await bookingService.search(searchText);
    return res.status(200).json(successResponse(200, 'Success', items));
  } catch (error) {
    next(error);
  }
}

export async function listWebBookings(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);
    const { items, total } = await bookingService.listWeb(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;
    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getBookingById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const booking = await bookingService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', booking));
  } catch (error) {
    next(error);
  }
}

export async function updateBookingStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const { status } = req.body;
    const booking = await bookingService.updateStatus(id, Number(status));
    return res.status(200).json(successResponse(200, 'Booking status updated successfully', booking));
  } catch (error) {
    next(error);
  }
}
