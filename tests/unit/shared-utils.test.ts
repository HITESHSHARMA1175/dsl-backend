import { AppError } from '../../src/shared/utils/appError';
import { hashPassword, comparePassword } from '../../src/shared/utils/hash.util';
import { generateOtp } from '../../src/shared/utils/otp.util';
import { calculatePagination } from '../../src/shared/utils/pagination.util';

describe('AppError', () => {
  it('should create an error with statusCode, message, and isOperational=true by default', () => {
    const error = new AppError(404, 'Not found');
    expect(error.statusCode).toBe(404);
    expect(error.message).toBe('Not found');
    expect(error.isOperational).toBe(true);
    expect(error).toBeInstanceOf(Error);
    expect(error).toBeInstanceOf(AppError);
  });

  it('should allow setting isOperational to false', () => {
    const error = new AppError(500, 'Internal error', false);
    expect(error.isOperational).toBe(false);
  });
});

describe('hashPassword / comparePassword', () => {
  it('should hash a password and verify it correctly', async () => {
    const password = 'securePass123';
    const hashed = await hashPassword(password);
    expect(hashed).not.toBe(password);
    expect(await comparePassword(password, hashed)).toBe(true);
  });

  it('should return false for incorrect password comparison', async () => {
    const hashed = await hashPassword('correctPassword');
    expect(await comparePassword('wrongPassword', hashed)).toBe(false);
  });
});

describe('generateOtp', () => {
  it('should generate a 4-digit numeric string between 1000 and 9999', () => {
    for (let i = 0; i < 100; i++) {
      const otp = generateOtp();
      expect(otp).toMatch(/^\d{4}$/);
      const num = parseInt(otp, 10);
      expect(num).toBeGreaterThanOrEqual(1000);
      expect(num).toBeLessThanOrEqual(9999);
    }
  });
});

describe('calculatePagination', () => {
  it('should calculate correct pagination metadata', () => {
    const result = calculatePagination(100, 2, 10);
    expect(result.total).toBe(100);
    expect(result.per_page).toBe(10);
    expect(result.current_page).toBe(2);
    expect(result.last_page).toBe(10);
    expect(result.next_page_url).toBe('?page=3&per_page=10');
    expect(result.prev_page_url).toBe('?page=1&per_page=10');
  });

  it('should return null next_page_url on last page', () => {
    const result = calculatePagination(20, 2, 10);
    expect(result.last_page).toBe(2);
    expect(result.next_page_url).toBeNull();
    expect(result.prev_page_url).toBe('?page=1&per_page=10');
  });

  it('should return null prev_page_url on first page', () => {
    const result = calculatePagination(50, 1, 10);
    expect(result.current_page).toBe(1);
    expect(result.prev_page_url).toBeNull();
    expect(result.next_page_url).toBe('?page=2&per_page=10');
  });

  it('should handle zero total items', () => {
    const result = calculatePagination(0, 1, 10);
    expect(result.total).toBe(0);
    expect(result.last_page).toBe(1);
    expect(result.current_page).toBe(1);
    expect(result.next_page_url).toBeNull();
    expect(result.prev_page_url).toBeNull();
  });

  it('should clamp page to last_page if page exceeds total pages', () => {
    const result = calculatePagination(25, 10, 10);
    expect(result.last_page).toBe(3);
    expect(result.current_page).toBe(3);
  });
});
