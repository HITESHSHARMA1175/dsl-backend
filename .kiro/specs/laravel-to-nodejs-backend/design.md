# Design Document: Laravel to Node.js Backend Migration

## Overview

This document details the architecture and technical design for migrating the DSL Clinic (Diamond Skin London) backend from Laravel 10 to an Express.js + TypeScript REST API. The system connects to the existing MySQL database via Prisma ORM (introspection-based), uses JWT authentication with refresh token rotation, and integrates Stripe, Klarna, SendGrid, and Twilio for payments and notifications.

## Architecture

The application follows a layered architecture pattern:

```
Client Request → Router → Middleware → Controller → Service → Repository (Prisma) → MySQL
```

- **Router Layer**: Defines RESTful endpoints and applies middleware
- **Middleware Layer**: Auth (JWT), validation (Zod), rate limiting, error handling
- **Controller Layer**: Request/response handling, input parsing, response formatting
- **Service Layer**: Business logic, orchestration, external API integration
- **Repository Layer**: Prisma ORM queries abstracted behind repository interfaces

## Project Structure

```
nodejs-backend/
├── prisma/
│   └── schema.prisma              # Introspected from existing MySQL DB
├── src/
│   ├── config/
│   │   ├── env.ts                 # Environment variable validation (Zod)
│   │   ├── database.ts            # Prisma client singleton + connection pooling
│   │   └── constants.ts           # App-wide constants (slot times, durations)
│   ├── middleware/
│   │   ├── auth.middleware.ts     # JWT verification + role extraction
│   │   ├── adminGuard.middleware.ts  # Admin role enforcement
│   │   ├── validate.middleware.ts # Zod schema validation
│   │   ├── rateLimiter.middleware.ts # Rate limiting (OTP attempts)
│   │   └── errorHandler.middleware.ts # Global error handler
│   ├── modules/
│   │   ├── auth/
│   │   │   ├── auth.controller.ts
│   │   │   ├── auth.service.ts
│   │   │   ├── auth.routes.ts
│   │   │   ├── auth.schema.ts    # Zod validation schemas
│   │   │   └── token.service.ts  # JWT sign/verify/refresh logic
│   │   ├── category/
│   │   │   ├── category.controller.ts
│   │   │   ├── category.service.ts
│   │   │   ├── category.routes.ts
│   │   │   └── category.schema.ts
│   │   ├── service/
│   │   │   ├── service.controller.ts
│   │   │   ├── service.service.ts
│   │   │   ├── service.routes.ts
│   │   │   └── service.schema.ts
│   │   ├── addon/
│   │   │   ├── addon.controller.ts
│   │   │   ├── addon.service.ts
│   │   │   ├── addon.routes.ts
│   │   │   └── addon.schema.ts
│   │   ├── treatment/
│   │   │   ├── treatment.controller.ts
│   │   │   ├── treatment.service.ts
│   │   │   ├── treatment.routes.ts
│   │   │   └── treatment.schema.ts
│   │   ├── professional/
│   │   │   ├── professional.controller.ts
│   │   │   ├── professional.service.ts
│   │   │   ├── professional.routes.ts
│   │   │   └── professional.schema.ts
│   │   ├── slot/
│   │   │   ├── slot.controller.ts
│   │   │   ├── slot.service.ts
│   │   │   ├── slot.routes.ts
│   │   │   └── slot.schema.ts
│   │   ├── booking/
│   │   │   ├── booking.controller.ts
│   │   │   ├── booking.service.ts
│   │   │   ├── booking.routes.ts
│   │   │   └── booking.schema.ts
│   │   ├── customer/
│   │   │   ├── customer.controller.ts
│   │   │   ├── customer.service.ts
│   │   │   ├── customer.routes.ts
│   │   │   └── customer.schema.ts
│   │   ├── order/
│   │   │   ├── order.controller.ts
│   │   │   ├── order.service.ts
│   │   │   ├── order.routes.ts
│   │   │   └── order.schema.ts
│   │   ├── payment/
│   │   │   ├── payment.controller.ts
│   │   │   ├── stripe.service.ts
│   │   │   ├── klarna.service.ts
│   │   │   ├── payment.routes.ts
│   │   │   └── payment.schema.ts
│   │   ├── clinic/
│   │   │   ├── clinic.controller.ts
│   │   │   ├── clinic.service.ts
│   │   │   ├── clinic.routes.ts
│   │   │   └── clinic.schema.ts
│   │   ├── content/
│   │   │   ├── content.controller.ts  # Banners, Reviews, FAQ, Blog, SEO
│   │   │   ├── content.service.ts
│   │   │   ├── content.routes.ts
│   │   │   └── content.schema.ts
│   │   └── master/
│   │       ├── master.controller.ts
│   │       ├── master.service.ts
│   │       ├── master.routes.ts
│   │       └── master.schema.ts
│   ├── shared/
│   │   ├── types/
│   │   │   ├── express.d.ts       # Express Request augmentation
│   │   │   └── api.types.ts       # Shared response types
│   │   ├── utils/
│   │   │   ├── response.util.ts   # Standardized response builders
│   │   │   ├── pagination.util.ts # Pagination helper
│   │   │   ├── otp.util.ts        # OTP generation + validation
│   │   │   └── hash.util.ts       # bcrypt wrapper
│   │   └── services/
│   │       ├── sendgrid.service.ts # Email delivery
│   │       └── twilio.service.ts   # SMS delivery (future OTP)
│   ├── app.ts                      # Express app setup, middleware registration
│   └── server.ts                   # Entry point, server start
├── tests/
│   ├── unit/
│   ├── integration/
│   └── properties/                 # Property-based tests
├── .env.example
├── package.json
├── tsconfig.json
└── jest.config.ts
```

## Data Models

The Prisma schema is generated via `prisma db pull` (introspection) from the existing MySQL database. Below are the key models mapped to existing tables. No destructive migrations are performed.

```prisma
datasource db {
  provider = "mysql"
  url      = env("DATABASE_URL")
}

generator client {
  provider = "prisma-client-js"
}

model User {
  id                Int       @id @default(autoincrement())
  name              String?
  email             String    @unique
  password          String
  mobile_no         String?
  first_name        String?
  last_name         String?
  profile           String?
  gender            String?
  status            String?   @default("1")
  is_admin          Int?      @default(0)
  is_sub_admin      Int?      @default(0)
  country           Int?
  state             Int?
  city              Int?
  designation       Int?
  device_token      String?
  device_type       String?
  remember_token    String?
  password_copy     String?
  email_verified_at DateTime?
  created_at        DateTime? @default(now())
  updated_at        DateTime? @updatedAt

  @@map("users")
}

model Customer {
  id             Int       @id @default(autoincrement())
  first_name     String?
  last_name      String?
  mobile         String?
  email          String?   @unique
  password       String?
  dob            String?
  gender         String?
  otp            String?
  otp_expires_at DateTime?
  otp_attempts   Int?      @default(0)
  otp_blocked_until DateTime?
  device_token   String?
  device_type    String?
  remember_token String?
  status         String?   @default("1")
  created_at     DateTime? @default(now())
  updated_at     DateTime? @updatedAt

  addresses      CustomerAddress[]
  bookings       KiBooking[]
  orders         Order[]

  @@map("customers")
}

model CustomerAddress {
  id           Int       @id @default(autoincrement())
  user_id      Int
  address_type String?
  country      String?
  state        String?
  city         String?
  address      String?
  pincode      String?
  created_at   DateTime? @default(now())
  updated_at   DateTime? @updatedAt

  customer     Customer  @relation(fields: [user_id], references: [id])

  @@map("customer_addresses")
}

model PropertyCategory {
  id             Int       @id @default(autoincrement())
  parent_id      Int?      @default(0)
  category_name  String?
  category_slug  String?
  main_category  Int?
  is_condition   Int?      @default(0)
  is_top         Int?      @default(0)
  sorting_order  Int?      @default(0)
  status         String?   @default("1")
  created_at     DateTime? @default(now())
  updated_at     DateTime? @updatedAt

  properties     Property[]

  @@map("property_categories")
}

model Property {
  id                         Int       @id @default(autoincrement())
  property_name              String?
  description                String?   @db.Text
  long_description           String?   @db.Text
  price                      Decimal?  @db.Decimal(10, 2)
  discounted_price           Decimal?  @db.Decimal(10, 2)
  number_of_members_required Int?      @default(1)
  duration                   Int?
  sessions                   Int?
  property_category          Int?
  property_sub_category      Int?
  parent_id                  Int?
  profile                    String?
  status                     String?   @default("1")
  created_at                 DateTime? @default(now())
  updated_at                 DateTime? @updatedAt

  category                   PropertyCategory? @relation(fields: [property_category], references: [id])

  @@map("properties")
}

model Addon {
  id                         Int       @id @default(autoincrement())
  parent_id                  Int?
  addon_name                 String?
  description                String?   @db.Text
  long_description           String?   @db.Text
  price                      Decimal?  @db.Decimal(10, 2)
  discounted_price           Decimal?  @db.Decimal(10, 2)
  number_of_members_required Int?      @default(1)
  duration                   Int?
  profile                    String?
  status                     String?   @default("1")
  created_at                 DateTime? @default(now())
  updated_at                 DateTime? @updatedAt

  @@map("addons")
}

model Treatment {
  id             Int       @id @default(autoincrement())
  name           String?
  treatment_type Int?
  status         String?   @default("1")
  created_at     DateTime? @default(now())
  updated_at     DateTime? @updatedAt

  @@map("treatments")
}

model Professional {
  id                Int       @id @default(autoincrement())
  professional_name String?
  designation       String?
  profession        String?
  parent_id         Int?
  category_ids      String?
  profile           String?
  rating            Decimal?  @db.Decimal(3, 1)
  status            String?   @default("1")
  created_at        DateTime? @default(now())
  updated_at        DateTime? @updatedAt

  bookings          KiBooking[]

  @@map("professionals")
}

model KiBooking {
  id                     Int       @id @default(autoincrement())
  user_id                Int?
  service_id             String?   @db.Text
  ssessionsystems        String?   @db.Text
  spricesystems          String?   @db.Text
  addon_id               String?   @db.Text
  profession_id          Int?
  total_service_duration Int?
  total_addon_duration   Int?
  clinic_id              Int?
  ddate                  DateTime? @db.Date
  slot_id                Int?
  slot_date              String?
  slot_time              String?
  first_name             String?
  last_name              String?
  email                  String?
  mobile                 String?
  payment_method_id      String?
  payment_method         String?
  payment_amount         Decimal?  @db.Decimal(10, 2)
  booking_status         String?   @default("pending")
  is_web                 String?   @default("0")
  status                 String?   @default("1")
  created_at             DateTime? @default(now())
  updated_at             DateTime? @updatedAt

  customer               Customer?     @relation(fields: [user_id], references: [id])
  professional           Professional? @relation(fields: [profession_id], references: [id])

  @@map("ki_bookings")
}

model Order {
  id                  Int       @id @default(autoincrement())
  user_id             Int?
  billing_first_name  String?
  billing_last_name   String?
  billing_phone       String?
  billing_email       String?
  billing_company     String?
  billing_country     String?
  billing_address_1   String?
  billing_city        String?
  billing_postcode    String?
  order_amount        Decimal?  @db.Decimal(10, 2)
  payment_method_id   String?
  payment_method      String?
  cart_details        String?   @db.Text
  order_status        String?   @default("pending")
  status              String?   @default("1")
  created_at          DateTime? @default(now())
  updated_at          DateTime? @updatedAt

  customer            Customer? @relation(fields: [user_id], references: [id])

  @@map("orders")
}

model Clinic {
  id          Int       @id @default(autoincrement())
  name        String?
  address     String?
  city        String?
  postcode    String?
  phone       String?
  email       String?
  status      String?   @default("1")
  created_at  DateTime? @default(now())
  updated_at  DateTime? @updatedAt

  @@map("clinics")
}

model MasterValue {
  id          Int       @id @default(autoincrement())
  MasterHead  Int?
  MasterValue String?
  status      String?   @default("1")
  created_at  DateTime? @default(now())
  updated_at  DateTime? @updatedAt

  @@map("master_values")
}

model Banner {
  id          Int       @id @default(autoincrement())
  title       String?
  image       String?
  link        String?
  status      String?   @default("1")
  created_at  DateTime? @default(now())
  updated_at  DateTime? @updatedAt

  @@map("banners")
}

model Review {
  id          Int       @id @default(autoincrement())
  name        String?
  rating      Int?
  review      String?   @db.Text
  status      String?   @default("1")
  created_at  DateTime? @default(now())
  updated_at  DateTime? @updatedAt

  @@map("reviews")
}

model Faq {
  id             Int       @id @default(autoincrement())
  question       String?
  answer         String?   @db.Text
  sorting_order  Int?      @default(0)
  status         String?   @default("1")
  created_at     DateTime? @default(now())
  updated_at     DateTime? @updatedAt

  @@map("faqs")
}

model Blog {
  id             Int       @id @default(autoincrement())
  title          String?
  slug           String?
  content        String?   @db.Text
  blog_category  Int?
  image          String?
  status         String?   @default("1")
  created_at     DateTime? @default(now())
  updated_at     DateTime? @updatedAt

  @@map("blogs")
}

model Seo {
  id              Int       @id @default(autoincrement())
  page_name       String?
  meta_title      String?
  meta_description String?  @db.Text
  meta_keywords   String?
  status          String?   @default("1")
  created_at      DateTime? @default(now())
  updated_at      DateTime? @updatedAt

  @@map("seos")
}

model RefreshToken {
  id          Int       @id @default(autoincrement())
  token       String    @unique
  user_id     Int
  user_type   String    // "admin" | "customer"
  expires_at  DateTime
  revoked     Boolean   @default(false)
  created_at  DateTime  @default(now())

  @@index([user_id, user_type])
  @@map("refresh_tokens")
}
```

> **Note:** The `refresh_tokens` table is the only new table introduced. All other models map to existing tables. The schema above is illustrative; actual field names and types come from `prisma db pull`.

## API Route Design

All endpoints are prefixed with `/api/v1`.

### Authentication Routes (`/api/v1/auth`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/auth/admin/login` | Public | Admin email + password login |
| POST | `/auth/admin/refresh` | Public | Refresh admin tokens |
| POST | `/auth/customer/request-otp` | Public | Request OTP for customer |
| POST | `/auth/customer/verify-otp` | Public | Verify OTP, return tokens |
| POST | `/auth/customer/refresh` | Public | Refresh customer tokens |

### Category Routes (`/api/v1/categories`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/categories` | Public | List categories (filter by parent_id) |
| POST | `/categories` | Admin | Create category |
| PUT | `/categories/:id` | Admin | Update category |
| DELETE | `/categories/:id` | Admin | Delete category |

### Service Routes (`/api/v1/services`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/services` | Public | List services (filter by category) |
| POST | `/services` | Admin | Create service |
| PUT | `/services/:id` | Admin | Update service |
| DELETE | `/services/:id` | Admin | Delete service |
| PATCH | `/services/:id/toggle-status` | Admin | Toggle active/inactive |

### Addon Routes (`/api/v1/addons`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/addons` | Public | List addons (filter by parent_id, paginated) |
| POST | `/addons` | Admin | Create addon |
| PUT | `/addons/:id` | Admin | Update addon |
| DELETE | `/addons/:id` | Admin | Delete addon |
| PATCH | `/addons/:id/toggle-status` | Admin | Toggle active/inactive |

### Treatment Routes (`/api/v1/treatments`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/treatments` | Admin | List treatments (filter by treatment_type) |
| POST | `/treatments` | Admin | Create treatment |
| PUT | `/treatments/:id` | Admin | Update treatment |
| DELETE | `/treatments/:id` | Admin | Delete treatment |

### Professional Routes (`/api/v1/professionals`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/professionals` | Public | List professionals (filter by parent_id) |
| POST | `/professionals` | Admin | Create professional |
| PUT | `/professionals/:id` | Admin | Update professional |
| DELETE | `/professionals/:id` | Admin | Delete professional |
| PATCH | `/professionals/:id/toggle-status` | Admin | Toggle active/inactive |

### Slot Routes (`/api/v1/slots`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/slots` | Public | Get available slots (professional_id, date, duration) |

### Booking Routes (`/api/v1/bookings`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/bookings` | Public | Create booking |
| GET | `/bookings` | Admin | List all bookings (paginated) |
| GET | `/bookings/search` | Admin | Search bookings by first_name |
| GET | `/bookings/:id` | Admin | Get booking detail |
| PATCH | `/bookings/:id/status` | Admin | Update booking status |

### Customer Routes (`/api/v1/customers`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/customers/profile` | Customer | Get own profile |
| PUT | `/customers/profile` | Customer | Update own profile |
| GET | `/customers/addresses` | Customer | List own addresses |
| POST | `/customers/addresses` | Customer | Create address |
| PUT | `/customers/addresses/:id` | Customer | Update address |
| GET | `/customers/bookings` | Customer | Booking history |
| GET | `/customers/orders` | Customer | Order history |

### Payment Routes (`/api/v1/payments`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| POST | `/payments/stripe/payment-intent` | Customer | Create PaymentIntent |
| POST | `/payments/stripe/checkout-session` | Public | Create Checkout Session |
| POST | `/payments/stripe/webhook` | Public | Stripe webhook handler |
| GET | `/payments/stripe/success` | Public | Handle checkout success redirect |
| POST | `/payments/klarna/session` | Public | Create Klarna session |
| POST | `/payments/klarna/order` | Public | Create Klarna order |
| DELETE | `/payments/klarna/authorization/:token` | Public | Cancel authorization |
| GET | `/payments/klarna/session/:id` | Public | Get session details |

### Clinic Routes (`/api/v1/clinics`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/clinics` | Admin | List all clinics |
| POST | `/clinics` | Admin | Create clinic |
| PUT | `/clinics/:id` | Admin | Update clinic |
| DELETE | `/clinics/:id` | Admin | Delete clinic |
| PATCH | `/clinics/:id/toggle-status` | Admin | Toggle active/inactive |

### Content Routes (`/api/v1/content`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/content/banners` | Admin | List banners |
| POST | `/content/banners` | Admin | Create banner |
| PUT | `/content/banners/:id` | Admin | Update banner |
| DELETE | `/content/banners/:id` | Admin | Delete banner |
| PATCH | `/content/banners/:id/toggle-status` | Admin | Toggle status |
| GET | `/content/reviews` | Admin | List reviews |
| POST | `/content/reviews` | Admin | Create review |
| PUT | `/content/reviews/:id` | Admin | Update review |
| DELETE | `/content/reviews/:id` | Admin | Delete review |
| PATCH | `/content/reviews/:id/toggle-status` | Admin | Toggle status |
| GET | `/content/faqs` | Admin | List FAQs |
| POST | `/content/faqs` | Admin | Create FAQ |
| PUT | `/content/faqs/:id` | Admin | Update FAQ |
| DELETE | `/content/faqs/:id` | Admin | Delete FAQ |
| PATCH | `/content/faqs/:id/toggle-status` | Admin | Toggle status |
| PATCH | `/content/faqs/sorting` | Admin | Update FAQ sorting |
| GET | `/content/blogs` | Admin | List blogs |
| POST | `/content/blogs` | Admin | Create blog |
| PUT | `/content/blogs/:id` | Admin | Update blog |
| DELETE | `/content/blogs/:id` | Admin | Delete blog |
| PATCH | `/content/blogs/:id/toggle-status` | Admin | Toggle status |
| GET | `/content/seo` | Admin | List SEO entries |
| POST | `/content/seo` | Admin | Create SEO entry |
| PUT | `/content/seo/:id` | Admin | Update SEO entry |
| DELETE | `/content/seo/:id` | Admin | Delete SEO entry |

### Master Routes (`/api/v1/master`)

| Method | Path | Auth | Description |
|--------|------|------|-------------|
| GET | `/master/values` | Public | Get MasterValues by MasterHead ID |

## Components and Interfaces

The Express middleware pipeline processes requests in this order:

```typescript
// src/app.ts
import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import { errorHandler } from './middleware/errorHandler.middleware';
import { routes } from './modules';

const app = express();

// 1. Security headers
app.use(helmet());

// 2. CORS
app.use(cors({ origin: process.env.CORS_ORIGINS?.split(',') ?? '*' }));

// 3. Body parsing (raw for Stripe webhooks, JSON for everything else)
app.use('/api/v1/payments/stripe/webhook', express.raw({ type: 'application/json' }));
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));

// 4. API routes
app.use('/api/v1', routes);

// 5. Global error handler (must be last)
app.use(errorHandler);
```

### Auth Middleware

```typescript
// src/middleware/auth.middleware.ts
import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';
import { env } from '../config/env';
import { errorResponse } from '../shared/utils/response.util';

interface JwtPayload {
  sub: number;       // user ID
  role: 'admin' | 'customer';
  iat: number;
  exp: number;
}

export function authMiddleware(req: Request, res: Response, next: NextFunction) {
  const authHeader = req.headers.authorization;
  if (!authHeader?.startsWith('Bearer ')) {
    return res.status(401).json(errorResponse(401, 'Unauthorized: No token provided'));
  }

  const token = authHeader.slice(7);
  try {
    const payload = jwt.verify(token, env.JWT_ACCESS_SECRET) as JwtPayload;
    req.user = { id: payload.sub, role: payload.role };
    next();
  } catch (err: any) {
    if (err.name === 'TokenExpiredError') {
      return res.status(401).json(errorResponse(401, 'Token has expired'));
    }
    return res.status(401).json(errorResponse(401, 'Invalid token'));
  }
}
```

### Admin Guard Middleware

```typescript
// src/middleware/adminGuard.middleware.ts
export function adminGuard(req: Request, res: Response, next: NextFunction) {
  if (req.user?.role !== 'admin') {
    return res.status(403).json(errorResponse(403, 'Forbidden: Admin access required'));
  }
  next();
}
```

### Validation Middleware

```typescript
// src/middleware/validate.middleware.ts
import { ZodSchema } from 'zod';

export function validate(schema: ZodSchema) {
  return (req: Request, res: Response, next: NextFunction) => {
    const result = schema.safeParse(req.body);
    if (!result.success) {
      const firstError = result.error.errors[0]?.message ?? 'Validation error';
      return res.status(400).json(errorResponse(400, firstError));
    }
    req.body = result.data;
    next();
  };
}
```

### Rate Limiter Middleware

```typescript
// src/middleware/rateLimiter.middleware.ts
import rateLimit from 'express-rate-limit';

export const otpRateLimiter = rateLimit({
  windowMs: 10 * 60 * 1000, // 10 minutes
  max: 5,                     // 5 attempts per window
  message: { error: true, status: 429, success: false, message: 'Too many attempts. Please try again in 10 minutes.' },
  keyGenerator: (req) => req.body.email || req.ip,
  standardHeaders: true,
  legacyHeaders: false,
});
```

### Error Handler Middleware

```typescript
// src/middleware/errorHandler.middleware.ts
import { Request, Response, NextFunction } from 'express';
import { env } from '../config/env';

export function errorHandler(err: Error, req: Request, res: Response, next: NextFunction) {
  const status = (err as any).statusCode ?? 500;
  const message = env.NODE_ENV === 'production'
    ? 'Internal server error'
    : err.message;

  res.status(status).json({
    error: true,
    status,
    success: false,
    message,
  });
}
```

## Service Layer Architecture

Each module's service encapsulates business logic and interacts with Prisma. Services are injected with the Prisma client and external service dependencies.

### Token Service

```typescript
// src/modules/auth/token.service.ts
import jwt from 'jsonwebtoken';
import crypto from 'crypto';
import { PrismaClient } from '@prisma/client';
import { env } from '../../config/env';

export class TokenService {
  constructor(private prisma: PrismaClient) {}

  generateAccessToken(userId: number, role: 'admin' | 'customer'): string {
    return jwt.sign(
      { sub: userId, role },
      env.JWT_ACCESS_SECRET,
      { expiresIn: '15m' }
    );
  }

  generateRefreshToken(): string {
    return crypto.randomBytes(40).toString('hex');
  }

  async storeRefreshToken(token: string, userId: number, userType: string): Promise<void> {
    const expiresAt = new Date(Date.now() + 7 * 24 * 60 * 60 * 1000); // 7 days
    await this.prisma.refreshToken.create({
      data: { token, user_id: userId, user_type: userType, expires_at: expiresAt },
    });
  }

  async rotateRefreshToken(oldToken: string, userId: number, userType: string) {
    // Invalidate old token
    await this.prisma.refreshToken.updateMany({
      where: { token: oldToken, user_id: userId },
      data: { revoked: true },
    });
    // Generate and store new token
    const newToken = this.generateRefreshToken();
    await this.storeRefreshToken(newToken, userId, userType);
    return newToken;
  }

  async validateRefreshToken(token: string): Promise<{ userId: number; userType: string } | null> {
    const record = await this.prisma.refreshToken.findUnique({ where: { token } });
    if (!record || record.revoked || record.expires_at < new Date()) {
      return null;
    }
    return { userId: record.user_id, userType: record.user_type };
  }
}
```

### Auth Service (Customer OTP flow)

```typescript
// src/modules/auth/auth.service.ts
import bcrypt from 'bcrypt';
import { PrismaClient } from '@prisma/client';
import { TokenService } from './token.service';
import { SendGridService } from '../../shared/services/sendgrid.service';
import { generateOtp } from '../../shared/utils/otp.util';

export class AuthService {
  constructor(
    private prisma: PrismaClient,
    private tokenService: TokenService,
    private sendgridService: SendGridService
  ) {}

  async adminLogin(email: string, password: string) {
    const user = await this.prisma.user.findFirst({
      where: { email, OR: [{ is_admin: 1 }, { is_sub_admin: 1 }] },
    });
    if (!user || !await bcrypt.compare(password, user.password)) {
      throw new AppError(401, 'Invalid credentials');
    }
    const accessToken = this.tokenService.generateAccessToken(user.id, 'admin');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, user.id, 'admin');
    return { accessToken, refreshToken };
  }

  async requestOtp(email: string) {
    let customer = await this.prisma.customer.findFirst({ where: { email } });
    if (!customer) {
      customer = await this.prisma.customer.create({ data: { email } });
    }
    const otp = generateOtp(); // 4-digit numeric
    const otpExpiresAt = new Date(Date.now() + 5 * 60 * 1000); // 5 minutes

    await this.prisma.customer.update({
      where: { id: customer.id },
      data: { otp, otp_expires_at: otpExpiresAt, otp_attempts: 0 },
    });

    await this.sendgridService.sendOtpEmail(email, otp);
    return { message: 'OTP sent to your email' };
  }

  async verifyOtp(email: string, otp: string) {
    const customer = await this.prisma.customer.findFirst({ where: { email } });
    if (!customer) throw new AppError(401, 'Invalid credentials');

    // Check rate limiting
    if (customer.otp_blocked_until && customer.otp_blocked_until > new Date()) {
      throw new AppError(429, 'Too many attempts. Please try again later.');
    }

    // Check expiry
    if (!customer.otp_expires_at || customer.otp_expires_at < new Date()) {
      throw new AppError(401, 'OTP has expired');
    }

    // Check OTP match
    if (customer.otp !== otp) {
      const attempts = (customer.otp_attempts ?? 0) + 1;
      const updateData: any = { otp_attempts: attempts };
      if (attempts >= 5) {
        updateData.otp_blocked_until = new Date(Date.now() + 10 * 60 * 1000);
      }
      await this.prisma.customer.update({ where: { id: customer.id }, data: updateData });
      throw new AppError(401, 'Invalid OTP');
    }

    // Clear OTP fields
    await this.prisma.customer.update({
      where: { id: customer.id },
      data: { otp: null, otp_expires_at: null, otp_attempts: 0, otp_blocked_until: null },
    });

    const accessToken = this.tokenService.generateAccessToken(customer.id, 'customer');
    const refreshToken = this.tokenService.generateRefreshToken();
    await this.tokenService.storeRefreshToken(refreshToken, customer.id, 'customer');
    return { accessToken, refreshToken };
  }
}
```

### Slot Availability Service

```typescript
// src/modules/slot/slot.service.ts
import { PrismaClient } from '@prisma/client';

interface Slot {
  id: number;
  slot_start: string;   // "HH:mm"
  slot_end: string;     // "HH:mm"
  formatted_date: string;
}

export class SlotService {
  private static readonly START_HOUR = 10;
  private static readonly END_HOUR = 17;
  private static readonly INTERVAL_MINUTES = 10;

  constructor(private prisma: PrismaClient) {}

  async getAvailableSlots(
    professionalId: number,
    date: string,
    totalServiceDuration: number
  ): Promise<Slot[]> {
    // Generate all possible 10-minute slots from 10:00 to 17:00
    const allSlots = this.generateTimeSlots();

    // Fetch existing bookings for this professional on this date
    const existingBookings = await this.prisma.kiBooking.findMany({
      where: { profession_id: professionalId, slot_date: date },
      select: { slot_time: true, total_service_duration: true },
    });

    // Filter out overlapping slots
    const availableSlots = allSlots.filter((slot) => {
      return !existingBookings.some((booking) =>
        this.hasOverlap(slot.slot_start, totalServiceDuration, booking.slot_time!, booking.total_service_duration!)
      );
    });

    return availableSlots.map((slot, index) => ({
      id: index + 1,
      slot_start: slot.slot_start,
      slot_end: this.addMinutes(slot.slot_start, totalServiceDuration),
      formatted_date: date,
    }));
  }

  private generateTimeSlots(): { slot_start: string }[] {
    const slots: { slot_start: string }[] = [];
    for (let hour = SlotService.START_HOUR; hour < SlotService.END_HOUR; hour++) {
      for (let min = 0; min < 60; min += SlotService.INTERVAL_MINUTES) {
        slots.push({ slot_start: `${String(hour).padStart(2, '0')}:${String(min).padStart(2, '0')}` });
      }
    }
    return slots;
  }

  private hasOverlap(
    slotStart: string, slotDuration: number,
    bookingStart: string, bookingDuration: number
  ): boolean {
    const slotStartMin = this.timeToMinutes(slotStart);
    const slotEndMin = slotStartMin + slotDuration;
    const bookingStartMin = this.timeToMinutes(bookingStart);
    const bookingEndMin = bookingStartMin + bookingDuration;
    return slotStartMin < bookingEndMin && bookingStartMin < slotEndMin;
  }

  private timeToMinutes(time: string): number {
    const [h, m] = time.split(':').map(Number);
    return h * 60 + m;
  }

  private addMinutes(time: string, minutes: number): string {
    const total = this.timeToMinutes(time) + minutes;
    return `${String(Math.floor(total / 60)).padStart(2, '0')}:${String(total % 60).padStart(2, '0')}`;
  }
}
```

### Payment Services

#### Stripe Service

```typescript
// src/modules/payment/stripe.service.ts
import Stripe from 'stripe';
import { env } from '../../config/env';

export class StripeService {
  private stripe: Stripe;

  constructor() {
    this.stripe = new Stripe(env.STRIPE_SECRET_KEY, { apiVersion: '2023-10-16' });
  }

  async createPaymentIntent(amountInPounds: number, paymentMethodId: string) {
    return this.stripe.paymentIntents.create({
      amount: Math.round(amountInPounds * 100), // Convert to pence
      currency: 'gbp',
      payment_method: paymentMethodId,
      confirm: true,
      return_url: env.STRIPE_RETURN_URL,
    });
  }

  async createCheckoutSession(amountInPounds: number, successUrl: string, cancelUrl: string) {
    return this.stripe.checkout.sessions.create({
      payment_method_types: ['card'],
      line_items: [{
        price_data: {
          currency: 'gbp',
          product_data: { name: 'Total Amount' },
          unit_amount: Math.round(amountInPounds * 100),
        },
        quantity: 1,
      }],
      mode: 'payment',
      success_url: successUrl,
      cancel_url: cancelUrl,
    });
  }

  verifyWebhookSignature(payload: Buffer, signature: string): Stripe.Event {
    return this.stripe.webhooks.constructEvent(payload, signature, env.STRIPE_WEBHOOK_SECRET);
  }

  async retrieveSession(sessionId: string) {
    return this.stripe.checkout.sessions.retrieve(sessionId);
  }
}
```

#### Klarna Service

```typescript
// src/modules/payment/klarna.service.ts
import axios, { AxiosInstance } from 'axios';
import { env } from '../../config/env';

export class KlarnaService {
  private client: AxiosInstance;

  constructor() {
    this.client = axios.create({
      baseURL: env.KLARNA_BASE_URL,
      auth: { username: env.KLARNA_USERNAME, password: env.KLARNA_PASSWORD },
      headers: { 'Content-Type': 'application/json' },
    });
  }

  async createSession(orderData: KlarnaOrderData) {
    const { data } = await this.client.post('/payments/v1/sessions', orderData);
    return data;
  }

  async createOrder(authorizationToken: string, orderData: KlarnaOrderData) {
    const { data } = await this.client.post(
      `/payments/v1/authorizations/${authorizationToken}/order`, orderData
    );
    return data;
  }

  async cancelAuthorization(token: string) {
    const { status } = await this.client.delete(`/payments/v1/authorizations/${token}`);
    return status;
  }

  async getSession(sessionId: string) {
    const { data } = await this.client.get(`/payments/v1/sessions/${sessionId}`);
    return data;
  }
}
```

### SendGrid Service

```typescript
// src/shared/services/sendgrid.service.ts
import axios from 'axios';
import { env } from '../../config/env';

export class SendGridService {
  private apiUrl = 'https://api.sendgrid.com/v3/mail/send';

  async sendOtpEmail(to: string, otp: string): Promise<void> {
    await this.send(to, 'OTP Verification', `Your OTP code is: ${otp}. It expires in 5 minutes.`);
  }

  async sendBookingConfirmation(to: string, data: BookingEmailData): Promise<void> {
    const html = `<h2>Booking Confirmed</h2>
      <p>Booking ID: ${data.bookingId}</p>
      <p>Amount: £${data.amount}</p>
      <p>Date: ${data.date}</p>
      <p>Time: ${data.time}</p>`;
    await this.send(to, 'DSL Clinic Booking Confirmation', html);
  }

  async sendOrderConfirmation(to: string, data: OrderEmailData): Promise<void> {
    const html = `<h2>Order Confirmed</h2>
      <p>Order ID: ${data.orderId}</p>
      <p>Amount: £${data.amount}</p>
      <p>Date: ${data.date}</p>`;
    await this.send(to, 'DSL Clinic Order Confirmation', html);
  }

  async sendWelcomeEmail(to: string, name: string): Promise<void> {
    await this.send(to, 'Welcome to DSL Clinic', `<h2>Welcome, ${name}!</h2>`);
  }

  private async send(to: string, subject: string, htmlContent: string): Promise<void> {
    await axios.post(this.apiUrl, {
      personalizations: [{ to: [{ email: to }] }],
      from: { email: env.SENDGRID_FROM_EMAIL, name: env.SENDGRID_FROM_NAME },
      subject,
      content: [{ type: 'text/html', value: htmlContent }],
    }, {
      headers: { Authorization: `Bearer ${env.SENDGRID_API_KEY}`, 'Content-Type': 'application/json' },
    });
  }
}
```

## Standardized Response Format

```typescript
// src/shared/utils/response.util.ts

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

export interface PaginatedData<T> {
  items: T[];
  pagination: {
    total: number;
    per_page: number;
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
  };
}

export function successResponse<T>(status: number, message: string, data: T): SuccessResponse<T> {
  return { error: false, status, success: true, message, data };
}

export function errorResponse(status: number, message: string): ErrorResponse {
  return { error: true, status, success: false, message };
}

export function paginatedResponse<T>(
  items: T[], total: number, page: number, perPage: number, baseUrl: string
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
```

## Authentication Flow

### Admin Login Flow

```
Client → POST /api/v1/auth/admin/login { email, password }
  → validate(schema) → authService.adminLogin()
  → bcrypt.compare(password, user.password)
  → generateAccessToken(userId, 'admin')
  → generateRefreshToken() + store in DB
  ← { accessToken, refreshToken }
```

### Customer OTP Flow

```
Client → POST /api/v1/auth/customer/request-otp { email }
  → validate(schema) → authService.requestOtp()
  → findOrCreate customer by email
  → generateOtp() → 4-digit random numeric
  → store OTP + otp_expires_at in customer record
  → sendgridService.sendOtpEmail(email, otp)
  ← { message: 'OTP sent' }

Client → POST /api/v1/auth/customer/verify-otp { email, otp }
  → validate(schema) → rateLimiter → authService.verifyOtp()
  → check blocked_until, check expiry, check OTP match
  → increment attempts on failure (block at 5)
  → on success: clear OTP fields, generate tokens
  ← { accessToken, refreshToken }
```

### Token Refresh Flow (Both Admin & Customer)

```
Client → POST /api/v1/auth/{admin|customer}/refresh { refreshToken }
  → tokenService.validateRefreshToken()
  → tokenService.rotateRefreshToken() [revoke old, create new]
  → generateAccessToken()
  ← { accessToken, refreshToken }
```

## Payment Integration Design

### Stripe Payment Flow (Checkout Session)

```
1. Client → POST /api/v1/payments/stripe/checkout-session { amount, metadata }
   → stripeService.createCheckoutSession(amount, successUrl, cancelUrl)
   ← { session_url }

2. Customer completes payment on Stripe-hosted page

3. Stripe → POST /api/v1/payments/stripe/webhook
   → verify signature (raw body + stripe-signature header)
   → if event.type === 'checkout.session.completed':
     → retrieve session details
     → findOrCreate customer by email
     → create KiBooking or Order record with payment_method='stripe'
     → send confirmation email

4. Client is redirected to success_url with session_id
   → GET /api/v1/payments/stripe/success?session_id=xxx
   → return booking/order confirmation
```

### Stripe PaymentIntent (Direct)

```
Client → POST /api/v1/payments/stripe/payment-intent { amount, payment_method_id }
  → stripeService.createPaymentIntent(amount, paymentMethodId)
  ← { paymentIntent }
```

### Klarna Payment Flow

```
1. Client → POST /api/v1/payments/klarna/session { order_lines }
   → klarnaService.createSession({ purchase_country: 'GB', purchase_currency: 'GBP', ... })
   ← { session_id, client_token, payment_method_categories }

2. Client renders Klarna widget using client_token

3. Client → POST /api/v1/payments/klarna/order { authorization_token, order_data }
   → klarnaService.createOrder(token, orderData)
   → create KiBooking or Order with payment_method='klarna'
   → send confirmation email
   ← { order_id, redirect_url }
```

## Environment Configuration

```typescript
// src/config/env.ts
import { z } from 'zod';

const envSchema = z.object({
  NODE_ENV: z.enum(['development', 'production', 'test']).default('development'),
  PORT: z.coerce.number().default(3000),

  // Database
  DATABASE_URL: z.string().url(),
  DATABASE_POOL_SIZE: z.coerce.number().default(10),

  // JWT
  JWT_ACCESS_SECRET: z.string().min(32),
  JWT_REFRESH_SECRET: z.string().min(32),

  // Stripe
  STRIPE_SECRET_KEY: z.string().startsWith('sk_'),
  STRIPE_WEBHOOK_SECRET: z.string().startsWith('whsec_'),
  STRIPE_RETURN_URL: z.string().url(),

  // Klarna
  KLARNA_BASE_URL: z.string().url(),
  KLARNA_USERNAME: z.string(),
  KLARNA_PASSWORD: z.string(),

  // SendGrid
  SENDGRID_API_KEY: z.string(),
  SENDGRID_FROM_EMAIL: z.string().email(),
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
```

## Database Configuration

```typescript
// src/config/database.ts
import { PrismaClient } from '@prisma/client';
import { env } from './env';

const prisma = new PrismaClient({
  datasources: {
    db: { url: env.DATABASE_URL },
  },
  log: env.NODE_ENV === 'development' ? ['query', 'error', 'warn'] : ['error'],
});

export default prisma;
```

Connection pooling is managed via the `DATABASE_URL` connection string parameter `?connection_limit=N` where N defaults to `DATABASE_POOL_SIZE`.

## Error Handling

All service-level errors are thrown as `AppError` instances:

```typescript
// src/shared/utils/appError.ts
export class AppError extends Error {
  public readonly statusCode: number;
  public readonly isOperational: boolean;

  constructor(statusCode: number, message: string, isOperational = true) {
    super(message);
    this.statusCode = statusCode;
    this.isOperational = isOperational;
    Object.setPrototypeOf(this, AppError.prototype);
  }
}
```

The global error handler catches these and formats them per the standardized response format. Prisma-specific errors (unique constraint violations, not found) are mapped to appropriate HTTP status codes in a dedicated Prisma error mapper utility.

## Testing Strategy

- **Unit tests (Jest)**: Verify individual service methods with mocked Prisma client and external services (Stripe, Klarna, SendGrid). Focus on specific scenarios, edge cases, and error conditions.
- **Property-based tests (fast-check)**: Verify universal properties across generated inputs for slot availability logic, response format consistency, token rotation, CRUD operations, and validation.
- **Integration tests**: Verify Prisma queries against a test MySQL database, verify end-to-end API flows including middleware chains.
- **Minimum 100 iterations** per property test to cover input variance.

## Correctness Properties

*A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.*

### Property 1: Valid authentication always produces token pair

*For any* valid admin credential pair (email + password matching a hashed record) or valid customer OTP (email + matching unexpired OTP), the authentication endpoint SHALL return a response containing both a non-empty access token and a non-empty refresh token.

**Validates: Requirements 1.1, 2.3**

### Property 2: Invalid credentials always produce 401

*For any* email and password combination where the email doesn't exist or the password hash doesn't match, and for any email and OTP combination where the OTP doesn't match or has expired, the authentication endpoint SHALL return a 401 status code.

**Validates: Requirements 1.2, 1.5, 2.4**

### Property 3: Refresh token rotation invalidates previous token

*For any* valid refresh token, after it is used to obtain a new token pair, the old refresh token SHALL be rejected (return 401) on any subsequent refresh attempt.

**Validates: Requirements 1.4, 1.7, 2.7**

### Property 4: OTP generation produces valid 4-digit codes

*For any* OTP request, the generated OTP SHALL be a numeric string of exactly 4 digits (value between 1000 and 9999 inclusive).

**Validates: Requirements 2.1**

### Property 5: List filtering returns only matching records

*For any* list endpoint with a filter parameter (parent_id for categories, property_category for services, parent_id for addons, treatment_type for treatments, parent_id for professionals, MasterHead for master values), all records in the response SHALL have the filtered field matching the provided filter value.

**Validates: Requirements 3.1, 4.1, 5.1, 6.1, 14.1, 17.1, 17.2, 17.3**

### Property 6: CRUD creation returns the created record

*For any* valid creation request to a CRUD endpoint (categories, services, addons, treatments, professionals, clinics, content entities), the response SHALL have status 201 and contain a data object with an `id` field and all submitted field values matching the request body.

**Validates: Requirements 3.2, 4.2, 5.2, 6.2, 14.2, 15.2, 16.1**

### Property 7: CRUD update reflects submitted changes

*For any* valid update request with a valid entity ID, the response record SHALL contain all submitted field values matching the update request body, and unmodified fields SHALL retain their previous values.

**Validates: Requirements 3.3, 4.3, 5.3, 6.3, 14.3, 15.3, 16.1**

### Property 8: Status toggle is an involution

*For any* entity with a status field (services, addons, professionals, clinics, content entities), toggling the status twice SHALL restore the original status value. A single toggle SHALL flip "1" to "0" or "0" to "1".

**Validates: Requirements 4.6, 5.6, 14.6, 15.5, 16.3**

### Property 9: Slot availability excludes overlapping bookings

*For any* set of existing bookings for a professional on a date, and any returned available slot, the time window [slot_start, slot_start + duration) SHALL NOT overlap with any existing booking's time window [booking_start, booking_start + booking_duration).

**Validates: Requirements 7.2, 7.3**

### Property 10: All generated slots are within operating hours

*For any* slot availability request, all returned slots SHALL have slot_start >= "10:00" and slot_end <= "17:00", and slot_start SHALL be on a 10-minute boundary (minutes divisible by 10).

**Validates: Requirements 7.1**

### Property 11: Booking creation persists all required fields

*For any* valid booking creation request, the resulting KiBooking database record SHALL contain the exact values submitted for service_id, profession_id, slot_date, slot_time, first_name, last_name, email, and mobile.

**Validates: Requirements 8.1, 8.4**

### Property 12: Booking links to correct customer (existing or new)

*For any* booking creation request, if the submitted email matches an existing customer record, the booking's user_id SHALL equal that customer's ID. If the email does not match any existing customer, a new customer record SHALL be created and the booking's user_id SHALL equal the new customer's ID.

**Validates: Requirements 8.2, 8.3**

### Property 13: User-scoped queries return only owned records

*For any* authenticated customer requesting their bookings, orders, or addresses, all records in the response SHALL have user_id equal to the authenticated customer's ID. No records belonging to other customers SHALL appear.

**Validates: Requirements 10.5, 11.1, 11.2**

### Property 14: Successful responses follow standard format

*For any* successful API response (status 2xx), the response body SHALL contain the fields: error (false), status (matching HTTP status), success (true), message (non-empty string), and data (object or array).

**Validates: Requirements 19.1**

### Property 15: Error responses follow standard format

*For any* error API response (status 4xx or 5xx), the response body SHALL contain the fields: error (true), status (matching HTTP status), success (false), and message (non-empty string).

**Validates: Requirements 19.2**

### Property 16: Paginated responses contain correct metadata

*For any* paginated list endpoint response, the pagination object SHALL contain total (>= 0), per_page (> 0), current_page (>= 1), last_page (>= 1), and last_page SHALL equal ceil(total / per_page). next_page_url SHALL be null when current_page >= last_page, and prev_page_url SHALL be null when current_page <= 1.

**Validates: Requirements 19.3**

### Property 17: Protected endpoints reject unauthenticated requests

*For any* protected endpoint (admin or customer), a request without a Bearer token in the Authorization header SHALL return 401. A request with an expired token SHALL return 401 with an expiry message.

**Validates: Requirements 20.1, 20.2, 20.3**

### Property 18: Role-based access control enforces boundaries

*For any* admin-only endpoint, a request bearing a valid customer-role JWT SHALL return 403. The JWT role claim SHALL match the user type: "admin" for admin users, "customer" for customer users.

**Validates: Requirements 20.4, 20.5**

### Property 19: Validation rejects invalid request bodies

*For any* endpoint with a defined Zod validation schema, a request body that violates the schema (missing required fields, wrong types, invalid formats) SHALL return a 400 status code with the first validation error as the message.

**Validates: Requirements 19.5, 3.5, 7.5, 8.5**

### Property 20: Webhook signature verification

*For any* Stripe webhook request, if the stripe-signature header contains a valid HMAC signature matching the raw request body and webhook secret, the event SHALL be processed. If the signature is invalid or missing, the request SHALL be rejected with 400.

**Validates: Requirements 12.4**

### Property 21: Email uniqueness constraint on customer profile update

*For any* customer profile update containing an email field, if another customer record already exists with that email, the API SHALL reject the update with a 400 status code. The constraint SHALL exclude the current customer's own record from the uniqueness check.

**Validates: Requirements 10.6**

### Property 22: Payment record creation stores correct payment metadata

*For any* successful Stripe checkout session completion or Klarna order creation, the resulting KiBooking or Order record SHALL have payment_method set to the correct provider ("stripe" or "klarna"), payment_method_id set to the transaction identifier, and payment_amount matching the charged amount.

**Validates: Requirements 12.3, 13.5**
