# Implementation Plan: Laravel to Node.js Backend Migration

## Overview

This plan converts the DSL Clinic backend from Laravel 10 to Express.js + TypeScript with Prisma ORM. Tasks are ordered by dependency: project foundation → shared utilities → auth module → CRUD modules → complex flows (booking, payments) → content/master → final integration. All code is created inside a new `nodejs-backend/` directory.

## Tasks

- [ ] 1. Project setup and configuration
  - [ ] 1.1 Initialize Node.js project with TypeScript
    - Create `nodejs-backend/` directory
    - Initialize `package.json` with scripts: `dev`, `build`, `start`, `test`, `prisma:generate`, `prisma:pull`
    - Install dependencies: express, cors, helmet, jsonwebtoken, bcrypt, zod, stripe, axios, express-rate-limit, dotenv
    - Install dev dependencies: typescript, ts-node, @types/express, @types/jsonwebtoken, @types/bcrypt, @types/cors, jest, ts-jest, @types/jest, fast-check, nodemon
    - Create `tsconfig.json` with strict mode, ESNext module, outDir `./dist`
    - Create `jest.config.ts` configured for ts-jest with paths for unit, integration, and property tests
    - _Requirements: 21.1_

  - [ ] 1.2 Set up environment configuration and validation
    - Create `src/config/env.ts` with Zod schema validating all environment variables (DATABASE_URL, JWT secrets, Stripe keys, Klarna credentials, SendGrid key, Twilio optionals, CORS_ORIGINS, PORT, NODE_ENV)
    - Create `.env.example` with all required variables documented
    - _Requirements: 12.6, 13.4, 18.5, 21.1, 21.5_

  - [ ] 1.3 Set up Prisma ORM and database connection
    - Install `prisma` and `@prisma/client`
    - Create `prisma/schema.prisma` with MySQL datasource and all models matching existing tables (User, Customer, CustomerAddress, PropertyCategory, Property, Addon, Treatment, Professional, KiBooking, Order, Clinic, MasterValue, Banner, Review, Faq, Blog, Seo, RefreshToken)
    - Create `src/config/database.ts` with PrismaClient singleton and connection pooling via DATABASE_URL parameter
    - _Requirements: 21.1, 21.2, 21.3, 21.5_

  - [ ] 1.4 Create Express app entry point and server startup
    - Create `src/app.ts` with Express app setup: helmet, CORS, raw body for Stripe webhook, JSON parsing, URL-encoded parsing, route mounting, global error handler
    - Create `src/server.ts` as entry point that loads dotenv, validates env, connects Prisma, starts HTTP server
    - _Requirements: 21.4_

- [ ] 2. Shared utilities and middleware
  - [ ] 2.1 Implement standardized response utilities
    - Create `src/shared/utils/response.util.ts` with `successResponse`, `errorResponse`, and `paginatedResponse` functions matching the design interfaces
    - Create `src/shared/types/api.types.ts` with SuccessResponse, ErrorResponse, PaginatedData interfaces
    - _Requirements: 19.1, 19.2, 19.3_

  - [ ] 2.2 Implement shared utility modules
    - Create `src/shared/utils/appError.ts` with AppError class (statusCode, message, isOperational)
    - Create `src/shared/utils/hash.util.ts` with bcrypt hash/compare wrappers (cost factor 10)
    - Create `src/shared/utils/otp.util.ts` with 4-digit OTP generation function
    - Create `src/shared/utils/pagination.util.ts` with pagination calculator helper
    - Create `src/shared/types/express.d.ts` with Express Request augmentation for `req.user`
    - _Requirements: 1.3, 2.1, 19.4_

  - [ ] 2.3 Implement middleware stack
    - Create `src/middleware/auth.middleware.ts` — JWT verification, role extraction into `req.user`
    - Create `src/middleware/adminGuard.middleware.ts` — Admin role enforcement returning 403
    - Create `src/middleware/validate.middleware.ts` — Zod schema validation, returns first error message with 400
    - Create `src/middleware/rateLimiter.middleware.ts` — OTP rate limiter (5 attempts per 10 min window)
    - Create `src/middleware/errorHandler.middleware.ts` — Global error handler with production/development modes
    - _Requirements: 19.4, 19.5, 20.1, 20.2, 20.3, 20.4, 20.5, 2.5_

  - [ ]* 2.4 Write property tests for response utilities and OTP generation
    - **Property 14: Successful responses follow standard format**
    - **Property 15: Error responses follow standard format**
    - **Property 4: OTP generation produces valid 4-digit codes**
    - **Validates: Requirements 19.1, 19.2, 2.1**

- [ ] 3. External service integrations
  - [ ] 3.1 Implement SendGrid email service
    - Create `src/shared/services/sendgrid.service.ts` with methods: `sendOtpEmail`, `sendBookingConfirmation`, `sendOrderConfirmation`, `sendWelcomeEmail`
    - Use SendGrid HTTP API with Bearer token auth
    - _Requirements: 18.1, 18.2, 18.3, 18.4, 18.5_

  - [ ] 3.2 Implement Twilio SMS service (stub for future OTP via SMS)
    - Create `src/shared/services/twilio.service.ts` with `sendSms` method using Twilio REST API
    - _Requirements: 2.1_

- [ ] 4. Authentication module
  - [ ] 4.1 Implement Token Service
    - Create `src/modules/auth/token.service.ts` with methods: `generateAccessToken` (15m expiry), `generateRefreshToken` (crypto random), `storeRefreshToken`, `rotateRefreshToken` (revoke old + create new), `validateRefreshToken`
    - _Requirements: 1.1, 1.4, 1.6, 1.7, 2.7_

  - [ ] 4.2 Implement Auth Service (admin login + customer OTP)
    - Create `src/modules/auth/auth.service.ts` with methods: `adminLogin` (bcrypt compare, token generation), `requestOtp` (find/create customer, generate OTP, store with expiry, send email), `verifyOtp` (check blocked, check expiry, check match, increment attempts, block at 5, generate tokens on success), `refreshTokens` (validate + rotate)
    - _Requirements: 1.1, 1.2, 1.3, 2.1, 2.2, 2.3, 2.4, 2.5, 2.6_

  - [ ] 4.3 Implement Auth Controller and Routes
    - Create `src/modules/auth/auth.schema.ts` with Zod schemas for adminLogin, requestOtp, verifyOtp, refreshToken
    - Create `src/modules/auth/auth.controller.ts` with handlers for each auth endpoint
    - Create `src/modules/auth/auth.routes.ts` with route definitions: POST `/admin/login`, POST `/admin/refresh`, POST `/customer/request-otp`, POST `/customer/verify-otp`, POST `/customer/refresh`
    - _Requirements: 1.1, 1.2, 1.4, 1.5, 2.1, 2.3, 2.4, 2.7_

  - [ ]* 4.4 Write property tests for authentication
    - **Property 1: Valid authentication always produces token pair**
    - **Property 2: Invalid credentials always produce 401**
    - **Property 3: Refresh token rotation invalidates previous token**
    - **Validates: Requirements 1.1, 1.2, 1.5, 1.4, 1.7, 2.3, 2.4, 2.7**

- [ ] 5. Checkpoint - Ensure auth module tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 6. Category module (CRUD)
  - [ ] 6.1 Implement Category service, controller, and routes
    - Create `src/modules/category/category.service.ts` with methods: `list` (filter by parent_id, default 0), `create`, `update`, `delete`
    - Create `src/modules/category/category.schema.ts` with Zod schemas for create (category_name required, parent_id), update
    - Create `src/modules/category/category.controller.ts` with CRUD handlers
    - Create `src/modules/category/category.routes.ts` — GET (public), POST/PUT/DELETE (admin-protected)
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

- [ ] 7. Service (Property) module (CRUD)
  - [ ] 7.1 Implement Service module
    - Create `src/modules/service/service.service.ts` with methods: `list` (filter by property_category, property_sub_category), `create`, `update`, `delete`, `toggleStatus`
    - Create `src/modules/service/service.schema.ts` with Zod schemas
    - Create `src/modules/service/service.controller.ts` with CRUD + toggle handlers
    - Create `src/modules/service/service.routes.ts` — GET (public), POST/PUT/DELETE/PATCH toggle (admin)
    - _Requirements: 4.1, 4.2, 4.3, 4.4, 4.5, 4.6_

- [ ] 8. Addon module (CRUD)
  - [ ] 8.1 Implement Addon module
    - Create `src/modules/addon/addon.service.ts` with methods: `list` (filter by parent_id, paginated 10/page), `create`, `update`, `delete`, `toggleStatus`
    - Create `src/modules/addon/addon.schema.ts` with Zod schemas
    - Create `src/modules/addon/addon.controller.ts` with CRUD + toggle handlers
    - Create `src/modules/addon/addon.routes.ts` — GET (public), POST/PUT/DELETE/PATCH toggle (admin)
    - _Requirements: 5.1, 5.2, 5.3, 5.4, 5.5, 5.6_

- [ ] 9. Treatment module (CRUD)
  - [ ] 9.1 Implement Treatment module
    - Create `src/modules/treatment/treatment.service.ts` with methods: `list` (filter by treatment_type), `create`, `update`, `delete`
    - Create `src/modules/treatment/treatment.schema.ts` with Zod schemas
    - Create `src/modules/treatment/treatment.controller.ts` with CRUD handlers
    - Create `src/modules/treatment/treatment.routes.ts` — all admin-protected
    - _Requirements: 6.1, 6.2, 6.3, 6.4, 6.5_

- [ ] 10. Professional module (CRUD)
  - [ ] 10.1 Implement Professional module
    - Create `src/modules/professional/professional.service.ts` with methods: `list` (filter by parent_id/service_id), `create`, `update`, `delete`, `toggleStatus`
    - Create `src/modules/professional/professional.schema.ts` with Zod schemas
    - Create `src/modules/professional/professional.controller.ts` with CRUD + toggle handlers
    - Create `src/modules/professional/professional.routes.ts` — GET (public), POST/PUT/DELETE/PATCH toggle (admin)
    - _Requirements: 14.1, 14.2, 14.3, 14.4, 14.5, 14.6_

  - [ ]* 10.2 Write property tests for CRUD modules
    - **Property 5: List filtering returns only matching records**
    - **Property 6: CRUD creation returns the created record**
    - **Property 7: CRUD update reflects submitted changes**
    - **Property 8: Status toggle is an involution**
    - **Validates: Requirements 3.1, 4.1, 5.1, 6.1, 14.1, 4.6, 5.6, 14.6, 15.5**

- [ ] 11. Checkpoint - Ensure CRUD module tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 12. Slot availability module
  - [ ] 12.1 Implement Slot Service
    - Create `src/modules/slot/slot.service.ts` with `getAvailableSlots` method: generate 10-minute interval slots from 10:00–17:00, fetch existing bookings for professional+date, filter overlapping slots using interval overlap logic
    - Create `src/modules/slot/slot.schema.ts` with Zod schema validating professional_id, date, total_service_duration (all required)
    - Create `src/modules/slot/slot.controller.ts` with GET handler
    - Create `src/modules/slot/slot.routes.ts` — GET (public)
    - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5_

  - [ ]* 12.2 Write property tests for slot availability
    - **Property 9: Slot availability excludes overlapping bookings**
    - **Property 10: All generated slots are within operating hours**
    - **Validates: Requirements 7.1, 7.2, 7.3**

- [ ] 13. Booking module
  - [ ] 13.1 Implement Booking Service
    - Create `src/modules/booking/booking.service.ts` with methods: `create` (find/create customer by email+mobile, create KiBooking record, send confirmation email), `list` (paginated), `search` (by first_name), `getById` (with relations), `updateStatus`
    - Create `src/modules/booking/booking.schema.ts` with Zod schemas for create (service_id, profession_id, slot_id, slot_date, first_name, last_name, email, mobile required), status update
    - Create `src/modules/booking/booking.controller.ts` with handlers
    - Create `src/modules/booking/booking.routes.ts` — POST create (public), GET list/search/detail (admin), PATCH status (admin)
    - _Requirements: 8.1, 8.2, 8.3, 8.4, 8.5, 8.6, 9.1, 9.2, 9.3, 9.4_

  - [ ]* 13.2 Write property tests for booking creation
    - **Property 11: Booking creation persists all required fields**
    - **Property 12: Booking links to correct customer (existing or new)**
    - **Validates: Requirements 8.1, 8.2, 8.3, 8.4**

- [ ] 14. Customer module
  - [ ] 14.1 Implement Customer Service
    - Create `src/modules/customer/customer.service.ts` with methods: `getProfile`, `updateProfile` (with email uniqueness check excluding self), `listAddresses`, `createAddress`, `updateAddress`, `getBookingHistory`, `getOrderHistory`
    - Create `src/modules/customer/customer.schema.ts` with Zod schemas for profile update, address create/update
    - Create `src/modules/customer/customer.controller.ts` with handlers
    - Create `src/modules/customer/customer.routes.ts` — all customer-auth protected
    - _Requirements: 10.1, 10.2, 10.3, 10.4, 10.5, 10.6, 11.1, 11.2, 11.3, 11.4_

  - [ ]* 14.2 Write property tests for customer data isolation
    - **Property 13: User-scoped queries return only owned records**
    - **Property 21: Email uniqueness constraint on customer profile update**
    - **Validates: Requirements 10.5, 10.6, 11.1, 11.2**

- [ ] 15. Checkpoint - Ensure booking and customer tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 16. Payment module (Stripe + Klarna)
  - [ ] 16.1 Implement Stripe Service
    - Create `src/modules/payment/stripe.service.ts` with methods: `createPaymentIntent` (GBP, confirm=true), `createCheckoutSession` (card payment method), `verifyWebhookSignature`, `retrieveSession`
    - _Requirements: 12.1, 12.2, 12.4, 12.6_

  - [ ] 16.2 Implement Klarna Service
    - Create `src/modules/payment/klarna.service.ts` with methods: `createSession`, `createOrder`, `cancelAuthorization`, `getSession` — all using axios with HTTP Basic Auth
    - _Requirements: 13.1, 13.2, 13.3, 13.4, 13.6_

  - [ ] 16.3 Implement Payment Controller and Routes
    - Create `src/modules/payment/payment.schema.ts` with Zod schemas for payment intent, checkout session, Klarna session/order
    - Create `src/modules/payment/payment.controller.ts` with handlers for: Stripe payment intent, checkout session, webhook, success redirect, Klarna session, order, cancel auth, get session
    - Create `src/modules/payment/payment.routes.ts` with route definitions per design table
    - Wire webhook handler to create KiBooking/Order records on successful payment with correct payment_method and payment_method_id
    - _Requirements: 12.1, 12.2, 12.3, 12.4, 12.5, 13.1, 13.2, 13.3, 13.5, 13.6_

  - [ ]* 16.4 Write property tests for payment processing
    - **Property 20: Webhook signature verification**
    - **Property 22: Payment record creation stores correct payment metadata**
    - **Validates: Requirements 12.3, 12.4, 13.5**

- [ ] 17. Clinic module (CRUD)
  - [ ] 17.1 Implement Clinic module
    - Create `src/modules/clinic/clinic.service.ts` with methods: `list`, `create`, `update`, `delete`, `toggleStatus`
    - Create `src/modules/clinic/clinic.schema.ts` with Zod schemas
    - Create `src/modules/clinic/clinic.controller.ts` with CRUD + toggle handlers
    - Create `src/modules/clinic/clinic.routes.ts` — all admin-protected
    - _Requirements: 15.1, 15.2, 15.3, 15.4, 15.5_

- [ ] 18. Content module (Banners, Reviews, FAQ, Blog, SEO)
  - [ ] 18.1 Implement Content module
    - Create `src/modules/content/content.service.ts` with generic CRUD methods for Banner, Review, Faq, Blog, Seo entities; include `toggleStatus` and FAQ `updateSorting`
    - Create `src/modules/content/content.schema.ts` with Zod schemas for each entity type
    - Create `src/modules/content/content.controller.ts` with CRUD + toggle + sorting handlers for all 5 entity types
    - Create `src/modules/content/content.routes.ts` with all content sub-routes — all admin-protected
    - _Requirements: 16.1, 16.2, 16.3, 16.4, 16.5_

- [ ] 19. Master values module
  - [ ] 19.1 Implement Master module
    - Create `src/modules/master/master.service.ts` with `getValues` method (filter by MasterHead ID)
    - Create `src/modules/master/master.schema.ts` with Zod query schema
    - Create `src/modules/master/master.controller.ts` with GET handler
    - Create `src/modules/master/master.routes.ts` — GET (public)
    - _Requirements: 17.1, 17.2, 17.3, 17.4_

- [ ] 20. Route aggregation and final wiring
  - [ ] 20.1 Wire all module routes into the main app
    - Create `src/modules/index.ts` that imports and registers all module routers under their respective prefixes (/auth, /categories, /services, /addons, /treatments, /professionals, /slots, /bookings, /customers, /payments, /clinics, /content, /master)
    - Verify all routes are mounted on `/api/v1` prefix
    - _Requirements: 20.6_

  - [ ]* 20.2 Write property tests for middleware and authorization
    - **Property 16: Paginated responses contain correct metadata**
    - **Property 17: Protected endpoints reject unauthenticated requests**
    - **Property 18: Role-based access control enforces boundaries**
    - **Property 19: Validation rejects invalid request bodies**
    - **Validates: Requirements 19.3, 19.5, 20.1, 20.2, 20.3, 20.4, 20.5**

- [ ] 21. Final checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation
- Property tests validate universal correctness properties from the design document
- Unit tests validate specific examples and edge cases
- The Prisma schema uses `prisma db pull` for introspection — the schema file in task 1.3 is a reference; actual generation happens against the live MySQL database
- The `refresh_tokens` table is the only new table; run `prisma db push` or a migration for it
- All modules follow the same pattern: service → schema → controller → routes

## Task Dependency Graph

```json
{
  "waves": [
    { "id": 0, "tasks": ["1.1"] },
    { "id": 1, "tasks": ["1.2", "1.3"] },
    { "id": 2, "tasks": ["1.4", "2.1", "2.2"] },
    { "id": 3, "tasks": ["2.3", "3.1", "3.2"] },
    { "id": 4, "tasks": ["2.4", "4.1"] },
    { "id": 5, "tasks": ["4.2"] },
    { "id": 6, "tasks": ["4.3", "4.4"] },
    { "id": 7, "tasks": ["6.1", "7.1", "8.1", "9.1", "10.1"] },
    { "id": 8, "tasks": ["10.2"] },
    { "id": 9, "tasks": ["12.1"] },
    { "id": 10, "tasks": ["12.2", "13.1"] },
    { "id": 11, "tasks": ["13.2", "14.1"] },
    { "id": 12, "tasks": ["14.2", "16.1", "16.2"] },
    { "id": 13, "tasks": ["16.3"] },
    { "id": 14, "tasks": ["16.4", "17.1", "18.1", "19.1"] },
    { "id": 15, "tasks": ["20.1"] },
    { "id": 16, "tasks": ["20.2"] }
  ]
}
```
