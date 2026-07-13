import { AppError } from './appError';

/**
 * Parses a route param (e.g. req.params.id) into a positive integer.
 * Throws a 400 AppError instead of silently producing NaN, which would
 * otherwise reach Prisma and surface as an opaque 500.
 */
export function parseIdParam(value: string | string[] | undefined): number {
  if (typeof value !== 'string') {
    throw new AppError(400, 'Invalid id parameter');
  }
  const id = Number(value);
  if (!Number.isInteger(id) || id <= 0) {
    throw new AppError(400, 'Invalid id parameter');
  }
  return id;
}
