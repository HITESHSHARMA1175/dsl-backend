import { z } from 'zod';
import dotenv from 'dotenv';

dotenv.config();

const envSchema = z.object({
  NODE_ENV: z.enum(['development', 'production', 'test']).default('development'),
  PORT: z.coerce.number().default(3000),

  // Database — real value provided via Render env var; placeholder lets the
  // app boot (and serve Swagger docs) even before the DB is wired.
  DATABASE_URL: z.string().min(1).default('mysql://root@127.0.0.1:3306/dslclinic_ds1db'),
  DATABASE_POOL_SIZE: z.coerce.number().default(10),

  // JWT — override with strong secrets in production (Render generates these).
  JWT_ACCESS_SECRET: z.string().min(32).default('dev_access_secret_change_me_0123456789abcdef'),
  JWT_REFRESH_SECRET: z.string().min(32).default('dev_refresh_secret_change_me_0123456789abcdef'),

  // Stripe (optional for docs deploy)
  STRIPE_SECRET_KEY: z.string().default('sk_test_placeholder'),
  STRIPE_WEBHOOK_SECRET: z.string().default('whsec_placeholder'),
  STRIPE_RETURN_URL: z.string().default('http://localhost:3000'),

  // Klarna (optional for docs deploy)
  KLARNA_BASE_URL: z.string().url().default('https://api.playground.klarna.com'),
  KLARNA_USERNAME: z.string().default(''),
  KLARNA_PASSWORD: z.string().default(''),

  // SendGrid (optional for docs deploy)
  SENDGRID_API_KEY: z.string().default(''),
  SENDGRID_FROM_EMAIL: z.string().default('noreply@dslclinic.com'),
  SENDGRID_FROM_NAME: z.string().default('DSL Clinic'),

  // Twilio (future SMS OTP)
  TWILIO_ACCOUNT_SID: z.string().optional(),
  TWILIO_AUTH_TOKEN: z.string().optional(),
  TWILIO_PHONE_NUMBER: z.string().optional(),

  // CORS
  CORS_ORIGINS: z.string().default('*'),
});

export const env = envSchema.parse(process.env);
export type Env = z.infer<typeof envSchema>;
