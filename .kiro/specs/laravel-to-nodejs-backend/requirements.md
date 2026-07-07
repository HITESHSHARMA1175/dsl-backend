# Requirements Document

## Introduction

This document specifies the requirements for migrating the DSL Clinic (Diamond Skin London) backend from Laravel 10 to a Node.js-based Express.js with TypeScript API. Phase 1 covers core modules: Authentication, Services/Treatments, Booking System, Customer Management, Payments, and Admin CRUD APIs. The new backend connects to the existing MySQL database via Prisma ORM and provides a RESTful JSON API with JWT-based authentication.

## Glossary

- **API_Server**: The Express.js TypeScript backend application serving RESTful endpoints
- **Admin_User**: A staff member with administrative privileges (identified by is_admin or is_sub_admin flags in the users table)
- **Customer**: An end-user of the skin clinic platform (stored in the customers table) who authenticates via OTP
- **JWT_Token**: A JSON Web Token used for stateless authentication, consisting of an access token and a refresh token
- **Access_Token**: A short-lived JWT (15 minutes) used to authorize API requests
- **Refresh_Token**: A long-lived JWT (7 days) used to obtain new access tokens without re-authentication
- **OTP**: A one-time password (4-digit numeric code) sent to a customer via email for verification
- **PropertyCategory**: A hierarchical service category (supports parent/child relationships via parent_id)
- **Property**: A clinic service record containing name, price, duration, sessions count, and category associations
- **Addon**: An add-on service or product linked to a category via parent_id
- **Treatment**: A clinical treatment record associated with a treatment type (MasterValue)
- **Professional**: A clinic practitioner who performs services and to whom bookings are assigned
- **KiBooking**: A service booking record linking a customer, service(s), addon(s), professional, slot date, and slot time
- **Slot**: A 10-minute time interval between 10:00 and 17:00 used for scheduling bookings
- **Order**: A product purchase record containing billing information, cart details, and payment references
- **MasterValue**: A configurable lookup value keyed by MasterHead ID (appointment types=4, treatment types=5, room types=7)
- **Stripe_PaymentIntent**: A Stripe API object representing a payment intent in GBP currency
- **Stripe_Checkout_Session**: A Stripe-hosted checkout page session for processing payments
- **Klarna_Session**: A Klarna payment session for buy-now-pay-later transactions
- **SendGrid_API**: The SendGrid email delivery service used for transactional emails
- **Twilio_API**: The Twilio SMS service used for OTP delivery
- **Clinic**: A physical clinic location record
- **Prisma_ORM**: The database access layer mapping TypeScript models to the existing MySQL schema

## Requirements

### Requirement 1: Admin Authentication

**User Story:** As an admin/staff user, I want to log in with email and password so that I receive JWT tokens to access protected admin endpoints.

#### Acceptance Criteria

1. WHEN an Admin_User submits valid email and password credentials to the login endpoint, THE API_Server SHALL return a JSON response containing an Access_Token and a Refresh_Token.
2. WHEN an Admin_User submits an invalid email or incorrect password, THE API_Server SHALL return a 401 status code with an error message indicating invalid credentials.
3. THE API_Server SHALL hash Admin_User passwords using bcrypt with a minimum cost factor of 10.
4. WHEN an Admin_User submits a valid Refresh_Token to the token refresh endpoint, THE API_Server SHALL return a new Access_Token and a new Refresh_Token.
5. WHEN an Admin_User submits an expired or invalid Refresh_Token, THE API_Server SHALL return a 401 status code with an error message indicating the token is invalid.
6. THE API_Server SHALL set the Access_Token expiry to 15 minutes and the Refresh_Token expiry to 7 days.
7. WHEN a Refresh_Token is used to obtain new tokens, THE API_Server SHALL invalidate the previously issued Refresh_Token (rotation).

### Requirement 2: Customer OTP Authentication

**User Story:** As a customer, I want to log in using my email address and an OTP so that I can securely access my account without a password.

#### Acceptance Criteria

1. WHEN a Customer submits an email address to the OTP request endpoint, THE API_Server SHALL generate a 4-digit numeric OTP and send the OTP to the provided email address via SendGrid_API.
2. WHEN a Customer submits an email address that does not exist in the customers table, THE API_Server SHALL create a new Customer record with the provided email and then send the OTP.
3. WHEN a Customer submits a valid email and correct OTP to the verification endpoint, THE API_Server SHALL return a JSON response containing an Access_Token and a Refresh_Token.
4. WHEN a Customer submits an incorrect OTP, THE API_Server SHALL return a 401 status code with an error message indicating the OTP is invalid.
5. IF a Customer submits more than 5 OTP verification attempts within 10 minutes, THEN THE API_Server SHALL return a 429 status code and block further attempts for 10 minutes.
6. THE API_Server SHALL expire generated OTPs after 5 minutes from creation.
7. WHEN a Customer submits a valid Refresh_Token to the token refresh endpoint, THE API_Server SHALL return a new Access_Token and a new Refresh_Token with rotation.

### Requirement 3: Service Category Management

**User Story:** As an admin, I want to manage hierarchical service categories so that services are organized into browsable groups.

#### Acceptance Criteria

1. THE API_Server SHALL provide a GET endpoint that returns PropertyCategory records filtered by parent_id, defaulting to 0 (root categories) when no parent_id is specified.
2. WHEN an Admin_User submits a valid PropertyCategory creation request with category_name and parent_id, THE API_Server SHALL create the PropertyCategory record and return the created record with a 201 status code.
3. WHEN an Admin_User submits a PropertyCategory update request with a valid category ID, THE API_Server SHALL update the specified fields and return the updated record.
4. WHEN an Admin_User submits a PropertyCategory deletion request, THE API_Server SHALL delete the category record and return a 200 status code with a success message.
5. IF an Admin_User submits a category creation request without a category_name, THEN THE API_Server SHALL return a 400 status code with a validation error message.
6. THE API_Server SHALL include the fields id, parent_id, and category_name in category list responses.

### Requirement 4: Service (Property) Management

**User Story:** As an admin, I want to manage clinic services so that customers can browse and book treatments.

#### Acceptance Criteria

1. THE API_Server SHALL provide a GET endpoint that returns Property records with optional filtering by property_category and property_sub_category query parameters.
2. WHEN an Admin_User submits a valid Property creation request, THE API_Server SHALL create the Property record and return the created record with a 201 status code.
3. WHEN an Admin_User submits a Property update request with a valid property ID, THE API_Server SHALL update the specified fields and return the updated record.
4. WHEN an Admin_User submits a Property deletion request with a valid property ID, THE API_Server SHALL delete the record and return a 200 status code.
5. THE API_Server SHALL include the fields id, property_name, description, long_description, price, discounted_price, number_of_members_required, and duration in service list responses.
6. WHEN a Property status toggle request is submitted, THE API_Server SHALL toggle the status field between active and inactive states.

### Requirement 5: Addon Management

**User Story:** As an admin, I want to manage add-on services so that customers can enhance their bookings with additional treatments.

#### Acceptance Criteria

1. THE API_Server SHALL provide a GET endpoint that returns Addon records filtered by parent_id (category ID) with pagination of 10 records per page.
2. WHEN an Admin_User submits a valid Addon creation request, THE API_Server SHALL create the Addon record and return the created record with a 201 status code.
3. WHEN an Admin_User submits an Addon update request with a valid addon ID, THE API_Server SHALL update the specified fields and return the updated record.
4. WHEN an Admin_User submits an Addon deletion request with a valid addon ID, THE API_Server SHALL delete the record and return a 200 status code.
5. THE API_Server SHALL include the fields id, parent_id, addon_name, description, long_description, price, discounted_price, number_of_members_required, duration, and profile image URL in addon list responses.
6. WHEN an Addon status toggle request is submitted, THE API_Server SHALL toggle the status field between active and inactive states.

### Requirement 6: Treatment Management

**User Story:** As an admin, I want to manage clinical treatments so that practitioners can associate treatments with appointments.

#### Acceptance Criteria

1. THE API_Server SHALL provide a GET endpoint that returns Treatment records filtered by treatment_type (MasterValue ID).
2. WHEN an Admin_User submits a valid Treatment creation request, THE API_Server SHALL create the Treatment record and return the created record with a 201 status code.
3. WHEN an Admin_User submits a Treatment update request with a valid treatment ID, THE API_Server SHALL update the specified fields and return the updated record.
4. WHEN an Admin_User submits a Treatment deletion request with a valid treatment ID, THE API_Server SHALL delete the record and return a 200 status code.
5. THE API_Server SHALL include the fields id and name in treatment list responses.

### Requirement 7: Slot Availability Calculation

**User Story:** As a customer, I want to see available time slots for a professional on a given date so that I can choose a convenient booking time.

#### Acceptance Criteria

1. WHEN a request is made with a professional_id, date, and total_service_duration, THE API_Server SHALL return available 10-minute interval slots between 10:00 and 17:00.
2. THE API_Server SHALL exclude slots that overlap with existing KiBooking records for the specified professional on the specified date.
3. THE API_Server SHALL calculate overlap by checking whether any existing booking falls within the window of (slot_start minus total_service_duration) to (slot_start plus total_service_duration) for the specified professional.
4. THE API_Server SHALL return each available slot with id, slot_start time, slot_end time (slot_start plus total_service_duration), and formatted date.
5. IF no professional_id or date is provided, THEN THE API_Server SHALL return a 400 status code with a validation error message.

### Requirement 8: Booking Creation

**User Story:** As a customer, I want to book a service with a professional at a selected time slot so that my appointment is confirmed.

#### Acceptance Criteria

1. WHEN a valid booking request is submitted with service_id, profession_id, slot_id, slot_date, first_name, last_name, email, and mobile, THE API_Server SHALL create a KiBooking record and return the booking_id with a 200 status code.
2. WHEN the submitted email or mobile matches an existing Customer record, THE API_Server SHALL associate the booking with the existing Customer user_id.
3. WHEN the submitted email and mobile do not match any existing Customer record, THE API_Server SHALL create a new Customer record and associate the booking with the new user_id.
4. THE API_Server SHALL store service_id, addon_id, profession_id, total_service_duration, total_addon_duration, slot_date, slot_time, and customer contact details in the KiBooking record.
5. IF any required field (service_id, profession_id, slot_id, slot_date, first_name, last_name, email, mobile) is missing, THEN THE API_Server SHALL return a 400 status code with the first validation error message.
6. WHEN a booking is successfully created, THE API_Server SHALL send a booking confirmation email to the Customer email via SendGrid_API.

### Requirement 9: Booking Search and Status Management

**User Story:** As an admin, I want to search and manage bookings so that I can track and update appointment statuses.

#### Acceptance Criteria

1. WHEN a search request is submitted with search_text, THE API_Server SHALL return KiBooking records where first_name matches the search_text.
2. THE API_Server SHALL provide a GET endpoint that returns all KiBooking records with pagination support.
3. WHEN an Admin_User submits a booking status update request with a valid booking ID, THE API_Server SHALL update the booking status and return the updated record.
4. THE API_Server SHALL return complete booking details including associated Customer, Professional, and service information in detail responses.

### Requirement 10: Customer Registration and Profile Management

**User Story:** As a customer, I want to manage my profile information so that my personal details and addresses are up to date.

#### Acceptance Criteria

1. WHEN an authenticated Customer submits a profile update request with first_name, last_name, mobile, dob, and gender, THE API_Server SHALL update the Customer record and return a success response.
2. WHEN an authenticated Customer requests their profile, THE API_Server SHALL return the Customer record including first_name, last_name, email, mobile, dob, and gender.
3. WHEN an authenticated Customer submits an address creation request with address_type, country, state, city, and address, THE API_Server SHALL create a CustomerAddress record linked to the Customer user_id.
4. WHEN an authenticated Customer submits an address update request with a valid address_id, THE API_Server SHALL update the specified CustomerAddress record.
5. WHEN an authenticated Customer requests their addresses, THE API_Server SHALL return all CustomerAddress records for that Customer.
6. THE API_Server SHALL validate that email is unique across customers excluding the current Customer record during profile updates.

### Requirement 11: Customer Booking and Order History

**User Story:** As a customer, I want to view my past bookings and orders so that I can track my treatment history and purchases.

#### Acceptance Criteria

1. WHEN an authenticated Customer requests their booking history, THE API_Server SHALL return all KiBooking records where user_id matches the authenticated Customer ID.
2. WHEN an authenticated Customer requests their order history, THE API_Server SHALL return all Order records where user_id matches the authenticated Customer ID.
3. THE API_Server SHALL include service details, professional details, slot date, slot time, and payment information in booking history responses.
4. THE API_Server SHALL include billing details, order amount, payment method, and cart details in order history responses.

### Requirement 12: Stripe Payment Processing

**User Story:** As a customer, I want to pay for bookings and product orders using Stripe so that my payment is processed securely.

#### Acceptance Criteria

1. WHEN a Stripe_PaymentIntent creation request is submitted with an amount and payment_method_id, THE API_Server SHALL create a Stripe PaymentIntent in GBP currency with confirm set to true and return the PaymentIntent object.
2. WHEN a Stripe_Checkout_Session creation request is submitted with an amount, THE API_Server SHALL create a Stripe Checkout Session with payment_method_types including card, and return the session URL.
3. WHEN a Stripe Checkout Session completes successfully, THE API_Server SHALL create the corresponding KiBooking or Order record with the payment_intent as payment_method_id and payment_method set to stripe.
4. WHEN a Stripe webhook event of type checkout.session.completed is received, THE API_Server SHALL verify the webhook signature and process the event.
5. IF a Stripe payment fails, THEN THE API_Server SHALL return a 500 status code with the error message from Stripe.
6. THE API_Server SHALL store the Stripe secret key and webhook secret in environment variables.

### Requirement 13: Klarna Payment Processing

**User Story:** As a customer, I want to pay using Klarna buy-now-pay-later so that I can spread the cost of treatments.

#### Acceptance Criteria

1. WHEN a Klarna_Session creation request is submitted with order line items, THE API_Server SHALL call the Klarna Payments API to create a session and return the session data including client_token.
2. WHEN a Klarna order creation request is submitted with an authorization token, THE API_Server SHALL call the Klarna Payments API to create an order and return the order confirmation.
3. WHEN a Klarna authorization cancellation request is submitted with a token, THE API_Server SHALL call the Klarna Payments API to cancel the authorization.
4. THE API_Server SHALL authenticate with the Klarna API using HTTP Basic Auth with username and password from environment variables.
5. WHEN a Klarna order is successfully created, THE API_Server SHALL create the corresponding KiBooking or Order record with payment_method set to klarna.
6. THE API_Server SHALL provide a GET endpoint to retrieve Klarna session details by session ID.

### Requirement 14: Professional Management

**User Story:** As an admin, I want to manage clinic professionals so that services can be assigned to qualified practitioners.

#### Acceptance Criteria

1. THE API_Server SHALL provide a GET endpoint that returns Professional records with optional filtering by parent_id (service_id).
2. WHEN an Admin_User submits a valid Professional creation request, THE API_Server SHALL create the Professional record and return the created record with a 201 status code.
3. WHEN an Admin_User submits a Professional update request with a valid professional ID, THE API_Server SHALL update the specified fields and return the updated record.
4. WHEN an Admin_User submits a Professional deletion request with a valid professional ID, THE API_Server SHALL delete the record and return a 200 status code.
5. THE API_Server SHALL include the fields id, professional_name, designation, profession, profile image, and rating in professional list responses.
6. WHEN a Professional status toggle request is submitted, THE API_Server SHALL toggle the status field between active and inactive states.

### Requirement 15: Clinic Management

**User Story:** As an admin, I want to manage clinic locations so that bookings and services can be associated with physical locations.

#### Acceptance Criteria

1. THE API_Server SHALL provide a GET endpoint that returns all Clinic records.
2. WHEN an Admin_User submits a valid Clinic creation request, THE API_Server SHALL create the Clinic record and return the created record with a 201 status code.
3. WHEN an Admin_User submits a Clinic update request with a valid clinic ID, THE API_Server SHALL update the specified fields and return the updated record.
4. WHEN an Admin_User submits a Clinic deletion request with a valid clinic ID, THE API_Server SHALL delete the record and return a 200 status code.
5. WHEN a Clinic status toggle request is submitted, THE API_Server SHALL toggle the status field between active and inactive states.

### Requirement 16: Admin Content Management (Banners, Reviews, FAQ, Blog, SEO)

**User Story:** As an admin, I want to manage content entities like banners, reviews, FAQs, blog posts, and SEO metadata so that the clinic website displays current information.

#### Acceptance Criteria

1. THE API_Server SHALL provide full CRUD endpoints (create, read, update, delete) for Banner, Review, FAQ, Blog, and SEO entities.
2. WHEN a list request is submitted for any content entity, THE API_Server SHALL return paginated results with status filtering support.
3. WHEN a status toggle request is submitted for any content entity, THE API_Server SHALL toggle the status field between active and inactive states.
4. WHEN a sorting update request is submitted for FAQ records, THE API_Server SHALL update the sorting_order field for the specified records.
5. THE API_Server SHALL require Admin_User authentication (valid Access_Token with admin privileges) for all content management endpoints.

### Requirement 17: MasterValue Lookup API

**User Story:** As a system consumer, I want to retrieve configurable lookup values so that appointment types, treatment types, and room types are loaded dynamically.

#### Acceptance Criteria

1. WHEN a request is made with MasterHead value 4, THE API_Server SHALL return all MasterValue records representing appointment types.
2. WHEN a request is made with MasterHead value 5, THE API_Server SHALL return all MasterValue records representing treatment types.
3. WHEN a request is made with MasterHead value 7, THE API_Server SHALL return all MasterValue records representing room types.
4. THE API_Server SHALL include the fields id and MasterValue (name) in lookup responses.

### Requirement 18: Email Notifications

**User Story:** As the system, I want to send transactional emails so that customers receive OTP codes, booking confirmations, order confirmations, and welcome messages.

#### Acceptance Criteria

1. WHEN a Customer requests an OTP, THE API_Server SHALL send an OTP email via SendGrid_API containing the generated code.
2. WHEN a KiBooking is successfully created with payment, THE API_Server SHALL send a booking confirmation email to the Customer email via SendGrid_API containing booking ID, amount, date, and time.
3. WHEN an Order is successfully created with payment, THE API_Server SHALL send an order confirmation email to the Customer email via SendGrid_API containing order ID, amount, date, and time.
4. WHEN a new Customer account is created and verified, THE API_Server SHALL send a welcome email via SendGrid_API.
5. THE API_Server SHALL use the SendGrid HTTP API with an API key stored in environment variables.

### Requirement 19: API Response Format and Error Handling

**User Story:** As an API consumer, I want consistent response formats so that client applications can reliably parse responses.

#### Acceptance Criteria

1. THE API_Server SHALL return all successful responses in the format: { error: false, status: number, success: true, message: string, data: object|array }.
2. THE API_Server SHALL return all error responses in the format: { error: true, status: number, success: false, message: string }.
3. THE API_Server SHALL return paginated list responses with pagination metadata containing total, per_page, current_page, last_page, next_page_url, and prev_page_url.
4. IF an unhandled exception occurs, THEN THE API_Server SHALL return a 500 status code with a generic error message in production and a detailed error message in development.
5. THE API_Server SHALL validate all request bodies and return a 400 status code with the first validation error message for invalid requests.

### Requirement 20: Authorization and Route Protection

**User Story:** As the system, I want to protect endpoints based on user roles so that only authorized users can access admin or customer-specific resources.

#### Acceptance Criteria

1. THE API_Server SHALL require a valid Access_Token in the Authorization header (Bearer scheme) for all protected endpoints.
2. WHEN a request is made without a valid Access_Token to a protected endpoint, THE API_Server SHALL return a 401 status code with an unauthorized error message.
3. WHEN a request is made with an expired Access_Token, THE API_Server SHALL return a 401 status code indicating the token has expired.
4. THE API_Server SHALL distinguish between Admin_User and Customer tokens via a role claim in the JWT payload.
5. WHEN a Customer token is used to access an admin-only endpoint, THE API_Server SHALL return a 403 status code with a forbidden error message.
6. THE API_Server SHALL allow public (unauthenticated) access to service listing, category listing, addon listing, professional listing, and slot availability endpoints.

### Requirement 21: Database Connectivity and ORM

**User Story:** As the system, I want to connect to the existing MySQL database using Prisma ORM so that all existing data is accessible through the new backend.

#### Acceptance Criteria

1. THE API_Server SHALL connect to the existing MySQL database using Prisma_ORM with connection parameters from environment variables.
2. THE API_Server SHALL use Prisma schema definitions that match the existing MySQL table structures without requiring destructive migrations.
3. THE API_Server SHALL use Prisma's introspection capability to generate schema from the existing database.
4. IF the database connection fails, THEN THE API_Server SHALL log the error and return a 503 status code for affected requests.
5. THE API_Server SHALL use connection pooling with a configurable pool size via environment variables.
