import jwt from 'jsonwebtoken';
import { TokenService } from '../../src/modules/auth/token.service';

// Mock environment
jest.mock('../../src/config/env', () => ({
  env: {
    JWT_ACCESS_SECRET: 'test-secret-key-that-is-at-least-32-chars-long',
    JWT_REFRESH_SECRET: 'test-refresh-secret-key-32-chars-long-xx',
  },
}));

describe('TokenService', () => {
  let tokenService: TokenService;
  let mockPrisma: any;

  beforeEach(() => {
    mockPrisma = {
      refreshToken: {
        create: jest.fn().mockResolvedValue({}),
        findUnique: jest.fn(),
        updateMany: jest.fn().mockResolvedValue({ count: 1 }),
      },
    };
    tokenService = new TokenService(mockPrisma);
  });

  describe('generateAccessToken', () => {
    it('should generate a valid JWT with correct payload for admin', () => {
      const token = tokenService.generateAccessToken(1, 'admin');
      const decoded = jwt.verify(token, 'test-secret-key-that-is-at-least-32-chars-long') as any;

      expect(decoded.sub).toBe(1);
      expect(decoded.role).toBe('admin');
      expect(decoded.exp).toBeDefined();
      expect(decoded.iat).toBeDefined();
    });

    it('should generate a valid JWT with correct payload for customer', () => {
      const token = tokenService.generateAccessToken(42, 'customer');
      const decoded = jwt.verify(token, 'test-secret-key-that-is-at-least-32-chars-long') as any;

      expect(decoded.sub).toBe(42);
      expect(decoded.role).toBe('customer');
    });

    it('should expire in 15 minutes', () => {
      const token = tokenService.generateAccessToken(1, 'admin');
      const decoded = jwt.verify(token, 'test-secret-key-that-is-at-least-32-chars-long') as any;

      const expectedExpiry = decoded.iat + 15 * 60; // 15 minutes in seconds
      expect(decoded.exp).toBe(expectedExpiry);
    });
  });

  describe('generateRefreshToken', () => {
    it('should generate an 80-character hex string', () => {
      const token = tokenService.generateRefreshToken();

      expect(token).toHaveLength(80); // 40 bytes = 80 hex chars
      expect(token).toMatch(/^[0-9a-f]{80}$/);
    });

    it('should generate unique tokens on each call', () => {
      const token1 = tokenService.generateRefreshToken();
      const token2 = tokenService.generateRefreshToken();

      expect(token1).not.toBe(token2);
    });
  });

  describe('storeRefreshToken', () => {
    it('should create a refresh token record with 7-day expiry', async () => {
      const now = Date.now();
      jest.spyOn(Date, 'now').mockReturnValue(now);

      await tokenService.storeRefreshToken('test-token', 1, 'admin');

      expect(mockPrisma.refreshToken.create).toHaveBeenCalledWith({
        data: {
          token: 'test-token',
          user_id: 1,
          user_type: 'admin',
          expires_at: new Date(now + 7 * 24 * 60 * 60 * 1000),
        },
      });

      jest.restoreAllMocks();
    });
  });

  describe('rotateRefreshToken', () => {
    it('should revoke the old token and return a new one', async () => {
      const result = await tokenService.rotateRefreshToken('old-token', 1, 'admin');

      // Old token should be revoked
      expect(mockPrisma.refreshToken.updateMany).toHaveBeenCalledWith({
        where: { token: 'old-token', user_id: 1 },
        data: { revoked: true },
      });

      // New token should be stored
      expect(mockPrisma.refreshToken.create).toHaveBeenCalled();

      // Should return an 80-char hex string (new refresh token)
      expect(result).toHaveLength(80);
      expect(result).toMatch(/^[0-9a-f]{80}$/);
    });
  });

  describe('validateRefreshToken', () => {
    it('should return userId and userType for a valid token', async () => {
      mockPrisma.refreshToken.findUnique.mockResolvedValue({
        token: 'valid-token',
        user_id: 5,
        user_type: 'customer',
        revoked: false,
        expires_at: new Date(Date.now() + 60000), // expires in the future
      });

      const result = await tokenService.validateRefreshToken('valid-token');

      expect(result).toEqual({ userId: 5, userType: 'customer' });
    });

    it('should return null for a revoked token', async () => {
      mockPrisma.refreshToken.findUnique.mockResolvedValue({
        token: 'revoked-token',
        user_id: 5,
        user_type: 'customer',
        revoked: true,
        expires_at: new Date(Date.now() + 60000),
      });

      const result = await tokenService.validateRefreshToken('revoked-token');

      expect(result).toBeNull();
    });

    it('should return null for an expired token', async () => {
      mockPrisma.refreshToken.findUnique.mockResolvedValue({
        token: 'expired-token',
        user_id: 5,
        user_type: 'customer',
        revoked: false,
        expires_at: new Date(Date.now() - 60000), // expired in the past
      });

      const result = await tokenService.validateRefreshToken('expired-token');

      expect(result).toBeNull();
    });

    it('should return null when token is not found', async () => {
      mockPrisma.refreshToken.findUnique.mockResolvedValue(null);

      const result = await tokenService.validateRefreshToken('nonexistent-token');

      expect(result).toBeNull();
    });
  });
});
