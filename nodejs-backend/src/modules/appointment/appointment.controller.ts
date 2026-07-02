import { Request, Response, NextFunction } from 'express';
import { AppointmentService } from './appointment.service';
import { prisma } from '../../config/database';
import { successResponse, paginatedResponse } from '../../shared/utils/response.util';

const appointmentService = new AppointmentService(prisma);

export async function createAppointment(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await appointmentService.create(req.body, req.user!.id);
    return res.status(200).json(successResponse(200, 'Appointment added successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function listAppointments(req: Request, res: Response, next: NextFunction) {
  try {
    const page = Math.max(1, Number(req.query.page) || 1);
    const perPage = Math.max(1, Number(req.query.per_page) || 10);

    const { items, total } = await appointmentService.list(page, perPage);
    const baseUrl = `${req.protocol}://${req.get('host')}${req.baseUrl}${req.path}`;

    return res.status(200).json(paginatedResponse(items, total, page, perPage, baseUrl));
  } catch (error) {
    next(error);
  }
}

export async function getAppointmentById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const appointment = await appointmentService.getById(id);
    return res.status(200).json(successResponse(200, 'Appointment details successfully', appointment));
  } catch (error) {
    next(error);
  }
}

export async function addAppointmentNotes(req: Request, res: Response, next: NextFunction) {
  try {
    const appointmentId = Number(req.params.id);
    const { notes } = req.body;
    const result = await appointmentService.addNotes(appointmentId, notes, req.user!.id);
    return res.status(200).json(successResponse(200, 'Appointment notes added successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function addAppointmentLogs(req: Request, res: Response, next: NextFunction) {
  try {
    const appointmentId = Number(req.params.id);
    const result = await appointmentService.addLogs(appointmentId, req.body, req.user!.id);
    return res.status(200).json(successResponse(200, 'Appointment action added successfully', result));
  } catch (error) {
    next(error);
  }
}
