import { Request, Response, NextFunction } from 'express';
import { AttendanceService } from './attendance.service';
import { prisma } from '../../config/database';
import { successResponse } from '../../shared/utils/response.util';

const attendanceService = new AttendanceService(prisma);

export async function markAttendance(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await attendanceService.markAttendance(req.user!.id, req.body);
    return res.status(200).json(successResponse(200, 'Attendance marked successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function punchOut(req: Request, res: Response, next: NextFunction) {
  try {
    const id = Number(req.params.id);
    const result = await attendanceService.punchOut(id, req.body);
    return res.status(200).json(successResponse(200, 'Punch out recorded successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function getMyAttendance(req: Request, res: Response, next: NextFunction) {
  try {
    const month = req.query.month ? Number(req.query.month) : undefined;
    const year = req.query.year ? Number(req.query.year) : undefined;
    const records = await attendanceService.getMyAttendance(req.user!.id, month, year);
    return res.status(200).json(successResponse(200, 'Attendance fetched successfully', records));
  } catch (error) {
    next(error);
  }
}

export async function getAllAttendance(req: Request, res: Response, next: NextFunction) {
  try {
    const month = req.query.month ? Number(req.query.month) : undefined;
    const year = req.query.year ? Number(req.query.year) : undefined;
    const records = await attendanceService.getAllAttendance(month, year);
    return res.status(200).json(successResponse(200, 'Attendance fetched successfully', records));
  } catch (error) {
    next(error);
  }
}

export async function addLeave(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await attendanceService.addLeave(req.user!.id, req.body);
    return res.status(201).json(successResponse(201, 'Leave added successfully', result));
  } catch (error) {
    next(error);
  }
}

export async function getMyLeaves(req: Request, res: Response, next: NextFunction) {
  try {
    const result = await attendanceService.getMyLeaves(req.user!.id);
    return res.status(200).json(successResponse(200, 'Leaves fetched successfully', result));
  } catch (error) {
    next(error);
  }
}
