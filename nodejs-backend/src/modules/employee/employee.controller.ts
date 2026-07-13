import { Request, Response, NextFunction } from 'express';
import { EmployeeService } from './employee.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const employeeService = new EmployeeService();

export async function listEmployees(req: Request, res: Response, next: NextFunction) {
  try {
    const filters = { search: req.query.search as string };
    const employees = await employeeService.list(filters);
    return res.status(200).json(successResponse(200, 'Success', employees));
  } catch (error) {
    next(error);
  }
}

export async function createEmployee(req: Request, res: Response, next: NextFunction) {
  try {
    const employee = await employeeService.create(req.body);
    return res.status(201).json(successResponse(201, 'Employee created', employee));
  } catch (error) {
    next(error);
  }
}

export async function updateEmployee(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const employee = await employeeService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Employee updated', employee));
  } catch (error) {
    next(error);
  }
}

export async function getEmployeeById(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const employee = await employeeService.getById(id);
    return res.status(200).json(successResponse(200, 'Success', employee));
  } catch (error) {
    next(error);
  }
}

export async function toggleEmployeeStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const employee = await employeeService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', employee));
  } catch (error) {
    next(error);
  }
}

export async function getEmployeeMap(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const map = await employeeService.getUserMap(id);
    return res.status(200).json(successResponse(200, 'Success', map));
  } catch (error) {
    next(error);
  }
}
