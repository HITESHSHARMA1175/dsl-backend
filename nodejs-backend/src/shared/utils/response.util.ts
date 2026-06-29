import { SuccessResponse, ErrorResponse, PaginatedData } from '../types/api.types';

/**
 * Build a standardized success response.
 *
 * @param status - HTTP status code
 * @param message - Human-readable message
 * @param data - Response payload
 */
export function successResponse<T>(status: number, message: string, data: T): SuccessResponse<T> {
  return { error: false, status, success: true, message, data };
}

/**
 * Build a standardized error response.
 *
 * @param status - HTTP status code
 * @param message - Human-readable error message
 */
export function errorResponse(status: number, message: string): ErrorResponse {
  return { error: true, status, success: false, message };
}

/**
 * Build a standardized paginated success response.
 *
 * @param items - Array of items for the current page
 * @param total - Total number of records across all pages
 * @param page - Current page number (1-based)
 * @param perPage - Number of records per page
 * @param baseUrl - Base URL for generating next/prev page links
 */
export function paginatedResponse<T>(
  items: T[],
  total: number,
  page: number,
  perPage: number,
  baseUrl: string
): SuccessResponse<PaginatedData<T>> {
  const lastPage = Math.ceil(total / perPage);
  return successResponse(200, 'Success', {
    items,
    pagination: {
      total,
      per_page: perPage,
      current_page: page,
      last_page: lastPage,
      next_page_url: page < lastPage ? `${baseUrl}?page=${page + 1}` : null,
      prev_page_url: page > 1 ? `${baseUrl}?page=${page - 1}` : null,
    },
  });
}
