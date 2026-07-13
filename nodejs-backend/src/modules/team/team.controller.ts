import { Request, Response, NextFunction } from 'express';
import { TeamService } from './team.service';
import { successResponse } from '../../shared/utils/response.util';
import { parseIdParam } from '../../shared/utils/parseId.util';

const teamService = new TeamService();

export async function listTeams(req: Request, res: Response, next: NextFunction) {
  try {
    const teams = await teamService.list();
    return res.status(200).json(successResponse(200, 'Success', teams));
  } catch (error) {
    next(error);
  }
}

export async function createTeam(req: Request, res: Response, next: NextFunction) {
  try {
    const team = await teamService.create(req.body);
    return res.status(201).json(successResponse(201, 'Team member created', team));
  } catch (error) {
    next(error);
  }
}

export async function updateTeam(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const team = await teamService.update(id, req.body);
    return res.status(200).json(successResponse(200, 'Team member updated', team));
  } catch (error) {
    next(error);
  }
}

export async function deleteTeam(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const result = await teamService.delete(id);
    return res.status(200).json(successResponse(200, result.message, null));
  } catch (error) {
    next(error);
  }
}

export async function toggleTeamStatus(req: Request, res: Response, next: NextFunction) {
  try {
    const id = parseIdParam(req.params.id);
    const team = await teamService.toggleStatus(id);
    return res.status(200).json(successResponse(200, 'Status toggled', team));
  } catch (error) {
    next(error);
  }
}
