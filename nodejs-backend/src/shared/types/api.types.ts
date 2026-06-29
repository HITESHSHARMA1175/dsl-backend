/**
 * Shared API response type interfaces
 * Standardized response format for all API endpoints
 */

export interface SuccessResponse<T = any> {
  error: false;
  status: number;
  success: true;
  message: string;
  data: T;
}

export interface ErrorResponse {
  error: true;
  status: number;
  success: false;
  message: string;
}

export interface PaginationMeta {
  total: number;
  per_page: number;
  current_page: number;
  last_page: number;
  next_page_url: string | null;
  prev_page_url: string | null;
}

export interface PaginatedData<T> {
  items: T[];
  pagination: PaginationMeta;
}
