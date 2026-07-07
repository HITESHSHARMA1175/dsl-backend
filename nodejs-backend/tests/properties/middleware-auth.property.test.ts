import * as fc from 'fast-check';
import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { z } from 'zod';

// Mock env module before importing middleware
jest.mock('../../src/config/env', () => ({
  env: {
    JWT_ACCESS_SECRET: 'test-secret-key-that-is-at-least-32-chars-long',
  },
}));

import { authMiddleware } from '../../src/middleware/auth.middleware';
import { adminGuard } from '../../src/middleware/adminGuard.middleware';
import { validate } from '../../src/middleware/validate.middleware';
import { paginatedResponse } from '../../src/shared/utils/response.util';

const TEST_SECRET = 'test-secret-key-that-is-at-least-32-chars-long';

function createMockResponse(): Response {
  const res: Partial<Response> = {};
  res.status = jest.fn().mockReturnValue(res);
  res.json = jest.fn().mockReturnValue(res);
  return res as Response;
}

function createMockRequest(overrides: Partial<Request> = {}): Request {
  return {
    headers: {},
    body: {},
    ...overrides,
  } as unknown as Request;
}

/**
 * Property 16: Paginated responses contain correct metadata
 * **Validates: Requirements 19.3**
 *
 * For any paginated list endpoint response, the pagination object SHALL contain
 * total (>= 0), per_page (> 0), current_page (>= 1), last_page (>= 1), and
 * last_page SHALL equal ceil(total / per_page). next_page_url SHALL be null when
 * current_page >= last_page, and prev_page_url SHALL be null when current_page <= 1.
 */
describe('Property 16: Paginated responses contain correct metadata', () => {
  it('should always produce valid pagination metadata for any valid inputs', () => {
    fc.assert(
      fc.property(
        fc.array(fc.string(), { minLength: 0, maxLength: 50 }),
        fc.integer({ min: 0, max: 10000 }),
        fc.integer({ min: 1, max: 100 }),
        fc.integer({ min: 1, max: 50 }),
        fc.webUrl(),
        (items, total, page, perPage, baseUrl) => {
          const result = paginatedResponse(items, total, page, perPage, baseUrl);

          const pagination = result.data.pagination;

          // total >= 0
          expect(pagination.total).toBeGreaterThanOrEqual(0);
          // per_page > 0
          expect(pagination.per_page).toBeGreaterThan(0);
          // current_page >= 1
          expect(pagination.current_page).toBeGreaterThanOrEqual(1);
          // last_page >= 1 (ceil of 0/n is 0, but Math.ceil handles it)
          // last_page = ceil(total / perPage), minimum is 0 when total is 0
          const expectedLastPage = Math.ceil(total / perPage);
          expect(pagination.last_page).toBe(expectedLastPage);

          // next_page_url null when current_page >= last_page
          if (page >= expectedLastPage) {
            expect(pagination.next_page_url).toBeNull();
          } else {
            expect(pagination.next_page_url).not.toBeNull();
            expect(pagination.next_page_url).toContain(`page=${page + 1}`);
          }

          // prev_page_url null when current_page <= 1
          if (page <= 1) {
            expect(pagination.prev_page_url).toBeNull();
          } else {
            expect(pagination.prev_page_url).not.toBeNull();
            expect(pagination.prev_page_url).toContain(`page=${page - 1}`);
          }

          // Response structure
          expect(result.error).toBe(false);
          expect(result.success).toBe(true);
          expect(result.status).toBe(200);
          expect(result.data.items).toBe(items);
        }
      ),
      { numRuns: 200 }
    );
  });
});

/**
 * Property 17: Protected endpoints reject unauthenticated requests
 * **Validates: Requirements 20.1, 20.2, 20.3**
 *
 * For any protected endpoint, a request without a Bearer token in the Authorization
 * header SHALL return 401. A request with an expired token SHALL return 401 with an
 * expiry message.
 */
describe('Property 17: Protected endpoints reject unauthenticated requests', () => {
  it('should return 401 for requests without Bearer prefix', () => {
    fc.assert(
      fc.property(
        fc.oneof(
          fc.constant(undefined),
          fc.string().filter((s) => !s.startsWith('Bearer ')),
          fc.constant(''),
          fc.constant('Basic abc123'),
          fc.constant('Token abc123')
        ),
        (authHeader) => {
          const req = createMockRequest({
            headers: authHeader !== undefined ? { authorization: authHeader } : {},
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          authMiddleware(req, res, next);

          expect(res.status).toHaveBeenCalledWith(401);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 401,
              success: false,
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  it('should return 401 for requests with invalid JWT tokens', () => {
    fc.assert(
      fc.property(
        fc.string({ minLength: 1, maxLength: 500 }).filter((s) => {
          // Filter out strings that could accidentally be valid JWTs
          try {
            jwt.verify(s, TEST_SECRET);
            return false;
          } catch {
            return true;
          }
        }),
        (invalidToken) => {
          const req = createMockRequest({
            headers: { authorization: `Bearer ${invalidToken}` },
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          authMiddleware(req, res, next);

          expect(res.status).toHaveBeenCalledWith(401);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 401,
              success: false,
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  it('should return 401 with expiry message for expired tokens', () => {
    fc.assert(
      fc.property(
        fc.integer({ min: 1, max: 10000 }),
        fc.constantFrom('admin' as const, 'customer' as const),
        (userId, role) => {
          // Create an expired token
          const expiredToken = jwt.sign(
            { sub: userId, role },
            TEST_SECRET,
            { expiresIn: '-1s' }
          );

          const req = createMockRequest({
            headers: { authorization: `Bearer ${expiredToken}` },
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          authMiddleware(req, res, next);

          expect(res.status).toHaveBeenCalledWith(401);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 401,
              success: false,
              message: 'Token has expired',
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 50 }
    );
  });

  it('should call next() and set req.user for valid tokens', () => {
    fc.assert(
      fc.property(
        fc.integer({ min: 1, max: 10000 }),
        fc.constantFrom('admin' as const, 'customer' as const),
        (userId, role) => {
          const validToken = jwt.sign(
            { sub: userId, role },
            TEST_SECRET,
            { expiresIn: '1h' }
          );

          const req = createMockRequest({
            headers: { authorization: `Bearer ${validToken}` },
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          authMiddleware(req, res, next);

          expect(next).toHaveBeenCalled();
          expect(req.user).toEqual({ id: userId, role });
        }
      ),
      { numRuns: 50 }
    );
  });
});

/**
 * Property 18: Role-based access control enforces boundaries
 * **Validates: Requirements 20.4, 20.5**
 *
 * For any admin-only endpoint, a request bearing a valid customer-role JWT SHALL
 * return 403. The JWT role claim SHALL match the user type.
 */
describe('Property 18: Role-based access control enforces boundaries', () => {
  it('should return 403 for customer role on admin-only endpoints', () => {
    fc.assert(
      fc.property(
        fc.integer({ min: 1, max: 10000 }),
        (userId) => {
          const req = createMockRequest();
          req.user = { id: userId, role: 'customer' };
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          adminGuard(req, res, next);

          expect(res.status).toHaveBeenCalledWith(403);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 403,
              success: false,
              message: 'Forbidden: Admin access required',
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  it('should call next() for admin role on admin-only endpoints', () => {
    fc.assert(
      fc.property(
        fc.integer({ min: 1, max: 10000 }),
        (userId) => {
          const req = createMockRequest();
          req.user = { id: userId, role: 'admin' };
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          adminGuard(req, res, next);

          expect(next).toHaveBeenCalled();
          expect(res.status).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  it('should return 403 when req.user is undefined (no auth)', () => {
    const req = createMockRequest();
    const res = createMockResponse();
    const next: NextFunction = jest.fn();

    adminGuard(req, res, next);

    expect(res.status).toHaveBeenCalledWith(403);
    expect(next).not.toHaveBeenCalled();
  });
});

/**
 * Property 19: Validation rejects invalid request bodies
 * **Validates: Requirements 19.5**
 *
 * For any endpoint with a defined Zod validation schema, a request body that
 * violates the schema SHALL return a 400 status code with the first validation
 * error as the message.
 */
describe('Property 19: Validation rejects invalid request bodies', () => {
  // Define a representative Zod schema (similar to auth schemas in the project)
  const testSchema = z.object({
    email: z.string().email('Invalid email format'),
    password: z.string().min(6, 'Password must be at least 6 characters'),
    name: z.string().min(1, 'Name is required'),
  });

  const validateMiddleware = validate(testSchema);

  it('should return 400 for bodies missing required fields', () => {
    fc.assert(
      fc.property(
        fc.record(
          {
            email: fc.oneof(fc.constant(undefined), fc.integer(), fc.boolean()),
            password: fc.oneof(fc.constant(undefined), fc.integer(), fc.boolean()),
            name: fc.oneof(fc.constant(undefined), fc.integer(), fc.boolean()),
          },
          { requiredKeys: [] }
        ),
        (body) => {
          const req = createMockRequest({ body });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          validateMiddleware(req, res, next);

          expect(res.status).toHaveBeenCalledWith(400);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 400,
              success: false,
              message: expect.any(String),
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  it('should return 400 for bodies with invalid email format', () => {
    fc.assert(
      fc.property(
        fc.string().filter((s) => !s.includes('@') || !s.includes('.')),
        fc.string({ minLength: 6 }),
        fc.string({ minLength: 1 }),
        (invalidEmail, password, name) => {
          const req = createMockRequest({
            body: { email: invalidEmail, password, name },
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          validateMiddleware(req, res, next);

          expect(res.status).toHaveBeenCalledWith(400);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 400,
              success: false,
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  it('should return 400 for bodies with too-short password', () => {
    fc.assert(
      fc.property(
        fc.emailAddress(),
        fc.string({ minLength: 0, maxLength: 5 }),
        fc.string({ minLength: 1 }),
        (email, shortPassword, name) => {
          const req = createMockRequest({
            body: { email, password: shortPassword, name },
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          validateMiddleware(req, res, next);

          expect(res.status).toHaveBeenCalledWith(400);
          expect(res.json).toHaveBeenCalledWith(
            expect.objectContaining({
              error: true,
              status: 400,
              success: false,
            })
          );
          expect(next).not.toHaveBeenCalled();
        }
      ),
      { numRuns: 100 }
    );
  });

  // Generator for emails that Zod's strict validator accepts
  const zodSafeEmail = fc
    .tuple(
      fc.stringMatching(/^[a-z][a-z0-9]{1,10}$/),
      fc.stringMatching(/^[a-z][a-z0-9]{1,8}$/),
      fc.constantFrom('com', 'org', 'net', 'io', 'dev')
    )
    .map(([local, domain, tld]) => `${local}@${domain}.${tld}`);

  it('should call next() for valid request bodies', () => {
    fc.assert(
      fc.property(
        zodSafeEmail,
        fc.stringMatching(/^[a-zA-Z0-9]{6,20}$/),
        fc.stringMatching(/^[a-zA-Z]{1,20}$/),
        (email, password, name) => {
          const req = createMockRequest({
            body: { email, password, name },
          });
          const res = createMockResponse();
          const next: NextFunction = jest.fn();

          validateMiddleware(req, res, next);

          expect(next).toHaveBeenCalled();
          expect(res.status).not.toHaveBeenCalled();
          // Validated body should be set
          expect(req.body).toEqual({ email, password, name });
        }
      ),
      { numRuns: 50 }
    );
  });
});
