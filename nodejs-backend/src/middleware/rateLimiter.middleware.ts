import rateLimit from 'express-rate-limit';

export const otpRateLimiter = rateLimit({
  windowMs: 10 * 60 * 1000, // 10 minutes
  max: 5, // 5 attempts per window
  message: {
    error: true,
    status: 429,
    success: false,
    message: 'Too many attempts. Please try again in 10 minutes.',
  },
  keyGenerator: (req) => req.body?.email || req.ip || 'unknown',
  standardHeaders: true,
  legacyHeaders: false,
});
