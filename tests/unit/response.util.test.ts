import { successResponse, errorResponse, paginatedResponse } from '../../src/shared/utils/response.util';

describe('Response Utilities', () => {
  describe('successResponse', () => {
    it('should return a correctly formatted success response', () => {
      const result = successResponse(200, 'OK', { id: 1, name: 'Test' });

      expect(result).toEqual({
        error: false,
        status: 200,
        success: true,
        message: 'OK',
        data: { id: 1, name: 'Test' },
      });
    });

    it('should handle null data', () => {
      const result = successResponse(200, 'No content', null);

      expect(result.error).toBe(false);
      expect(result.success).toBe(true);
      expect(result.data).toBeNull();
    });

    it('should handle array data', () => {
      const result = successResponse(200, 'List', [1, 2, 3]);

      expect(result.data).toEqual([1, 2, 3]);
      expect(result.status).toBe(200);
    });

    it('should support 201 status for creation', () => {
      const result = successResponse(201, 'Created', { id: 5 });

      expect(result.status).toBe(201);
      expect(result.message).toBe('Created');
    });
  });

  describe('errorResponse', () => {
    it('should return a correctly formatted error response', () => {
      const result = errorResponse(400, 'Bad Request');

      expect(result).toEqual({
        error: true,
        status: 400,
        success: false,
        message: 'Bad Request',
      });
    });

    it('should handle 401 unauthorized', () => {
      const result = errorResponse(401, 'Unauthorized');

      expect(result.error).toBe(true);
      expect(result.success).toBe(false);
      expect(result.status).toBe(401);
      expect(result.message).toBe('Unauthorized');
    });

    it('should handle 500 internal server error', () => {
      const result = errorResponse(500, 'Internal server error');

      expect(result.status).toBe(500);
      expect(result.message).toBe('Internal server error');
    });
  });

  describe('paginatedResponse', () => {
    it('should return correct pagination metadata', () => {
      const items = [{ id: 1 }, { id: 2 }];
      const result = paginatedResponse(items, 20, 1, 10, '/api/v1/items');

      expect(result.error).toBe(false);
      expect(result.success).toBe(true);
      expect(result.status).toBe(200);
      expect(result.data.items).toEqual(items);
      expect(result.data.pagination).toEqual({
        total: 20,
        per_page: 10,
        current_page: 1,
        last_page: 2,
        next_page_url: '/api/v1/items?page=2',
        prev_page_url: null,
      });
    });

    it('should have prev_page_url when not on first page', () => {
      const result = paginatedResponse([], 30, 2, 10, '/api/v1/items');

      expect(result.data.pagination.prev_page_url).toBe('/api/v1/items?page=1');
      expect(result.data.pagination.next_page_url).toBe('/api/v1/items?page=3');
    });

    it('should have null next_page_url on last page', () => {
      const result = paginatedResponse([], 20, 2, 10, '/api/v1/items');

      expect(result.data.pagination.next_page_url).toBeNull();
      expect(result.data.pagination.prev_page_url).toBe('/api/v1/items?page=1');
    });

    it('should calculate last_page correctly', () => {
      const result = paginatedResponse([], 25, 1, 10, '/api/v1/items');

      expect(result.data.pagination.last_page).toBe(3);
    });

    it('should handle single page of results', () => {
      const result = paginatedResponse([{ id: 1 }], 1, 1, 10, '/api/v1/items');

      expect(result.data.pagination.last_page).toBe(1);
      expect(result.data.pagination.next_page_url).toBeNull();
      expect(result.data.pagination.prev_page_url).toBeNull();
    });

    it('should handle empty results', () => {
      const result = paginatedResponse([], 0, 1, 10, '/api/v1/items');

      expect(result.data.items).toEqual([]);
      expect(result.data.pagination.total).toBe(0);
      expect(result.data.pagination.last_page).toBe(0);
      expect(result.data.pagination.next_page_url).toBeNull();
      expect(result.data.pagination.prev_page_url).toBeNull();
    });
  });
});
