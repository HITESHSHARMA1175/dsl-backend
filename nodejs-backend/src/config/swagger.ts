/**
 * Complete Static Swagger/OpenAPI 3.0 Specification
 * Covers all 47 modules with 224 endpoints
 */

export function generateSwaggerSpec(app: any) {
  const swaggerSpec: any = {
    openapi: '3.0.0',
    info: {
      title: 'DSL Clinic API',
      version: '1.0.0',
      description: 'Complete REST API documentation for the DSL Clinic backend application.',
      contact: { name: 'DSL Team' },
    },
    servers: [
      { url: '/api/v1', description: 'API v1' },
    ],
    components: {
      securitySchemes: {
        BearerAuth: {
          type: 'http',
          scheme: 'bearer',
          bearerFormat: 'JWT',
        },
      },
    },
    tags: [
      { name: 'Auth', description: 'Authentication & authorization' },
      { name: 'Categories', description: 'Service categories management' },
      { name: 'Services', description: 'Services management' },
      { name: 'Addons', description: 'Service add-ons management' },
      { name: 'Treatments', description: 'Treatments management' },
      { name: 'Professionals', description: 'Professionals management' },
      { name: 'Slots', description: 'Appointment slot availability' },
      { name: 'Bookings', description: 'Booking management' },
      { name: 'Customers', description: 'Customer profile & data' },
      { name: 'Payments', description: 'Payment processing (Stripe & Klarna)' },
      { name: 'Clinics', description: 'Clinic management' },
      { name: 'Content', description: 'CMS content (Banners, Reviews, FAQs, Blogs, SEO)' },
      { name: 'Master', description: 'Master data values' },
      { name: 'Appointments', description: 'Appointments management' },
      { name: 'Attendance', description: 'Staff attendance tracking' },
      { name: 'Patients', description: 'Patient records management' },
      { name: 'Leads', description: 'Lead management (CRM)' },
      { name: 'Concerns', description: 'Patient concerns management' },
      { name: 'Employees', description: 'Employee management' },
      { name: 'Skin Conditions', description: 'Skin conditions catalog' },
      { name: 'Consultation Forms', description: 'Consultation form records' },
      { name: 'Medical History', description: 'Medical history templates' },
      { name: 'Teams', description: 'Team management' },
      { name: 'Sales CRM', description: 'Sales CRM pipeline' },
      { name: 'Seller CRM', description: 'Seller CRM pipeline' },
      { name: 'Inventory', description: 'Inventory management' },
      { name: 'Vendors', description: 'Vendor management' },
      { name: 'Redirects', description: 'URL redirects management' },
      { name: 'Clinical Options', description: 'Clinical options management' },
      { name: 'Notifications', description: 'Push notifications' },
      { name: 'Dashboard', description: 'Dashboard statistics' },
      { name: 'Home', description: 'Home page data' },
      { name: 'Buyer CRM', description: 'Buyer CRM pipeline' },
      { name: 'Attributes', description: 'Product attributes management' },
      { name: 'Mobile', description: 'Mobile device catalog (Brands, Models, Variants, Colours)' },
      { name: 'Move Details', description: 'Move-in/out details management' },
      { name: 'Owners', description: 'Property owners management' },
      { name: 'Tenants', description: 'Tenants management' },
      { name: 'Reports', description: 'Business reports' },
      { name: 'Common', description: 'Common lookup data (Countries, States, Cities)' },
      { name: 'Cron', description: 'Cron job triggers' },
      { name: 'Societies', description: 'Societies management' },
      { name: 'Builders', description: 'Builders management' },
      { name: 'Designations', description: 'Designations management' },
      { name: 'Inventory Categories', description: 'Inventory categories management' },
      { name: 'Export', description: 'Data export endpoints' },
      { name: 'Import', description: 'Data import endpoints' },
      { name: 'Orders', description: 'Shop/product order management' },
      { name: 'Service Categories', description: 'Service category hierarchy (main/category/sub-category)' },
      { name: 'Data CRM', description: 'Data lead pipeline (separate from sales leads)' },
      { name: 'Sub Admins', description: 'Sub-admin user management' },
      { name: 'Sellers', description: 'Seller management with KYC approval' },
      { name: 'Cart', description: 'Guest shopping cart & checkout' },
      { name: 'Subscribe', description: 'Newsletter / consultation subscriptions' },
      { name: 'Property', description: 'Co-living / property listings, rooms and beds' },
      { name: 'Agent', description: 'Agent/seller mobile app: auth, profile, KYC, business, payments' },
      { name: 'Storefront', description: 'Storefront selection session: services/addons/products, slots, language, search' },
    ],
    paths: {
      // ==================== AUTH (9 endpoints) ====================
      '/auth/admin/login': {
        post: {
          tags: ['Auth'],
          summary: 'Admin login',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['email', 'password'], properties: { email: { type: 'string', format: 'email' }, password: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Login successful, returns tokens' }, '401': { description: 'Invalid credentials' } },
        },
      },
      '/auth/admin/refresh': {
        post: {
          tags: ['Auth'],
          summary: 'Refresh admin access token',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['refreshToken'], properties: { refreshToken: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'New access token returned' }, '401': { description: 'Invalid refresh token' } },
        },
      },
      '/auth/customer/register': {
        post: {
          tags: ['Auth'],
          summary: 'Register a new customer',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['first_name', 'email', 'password'], properties: { first_name: { type: 'string' }, email: { type: 'string', format: 'email' }, password: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Customer registered successfully' }, '409': { description: 'Email already exists' } },
        },
      },
      '/auth/customer/login': {
        post: {
          tags: ['Auth'],
          summary: 'Customer login',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['email', 'password'], properties: { email: { type: 'string', format: 'email' }, password: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Login successful, returns tokens' }, '401': { description: 'Invalid credentials' } },
        },
      },
      '/auth/customer/refresh': {
        post: {
          tags: ['Auth'],
          summary: 'Refresh customer access token',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['refreshToken'], properties: { refreshToken: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'New access token returned' }, '401': { description: 'Invalid refresh token' } },
        },
      },
      '/auth/forgot-password': {
        post: {
          tags: ['Auth'],
          summary: 'Request password reset email',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['email'], properties: { email: { type: 'string', format: 'email' } } } } },
          },
          responses: { '200': { description: 'Reset email sent' }, '404': { description: 'Email not found' } },
        },
      },
      '/auth/reset-password': {
        post: {
          tags: ['Auth'],
          summary: 'Reset password using token',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['token', 'password'], properties: { token: { type: 'string' }, password: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Password reset successful' }, '400': { description: 'Invalid or expired token' } },
        },
      },
      '/auth/change-password': {
        post: {
          tags: ['Auth'],
          summary: 'Change password (authenticated)',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['current_password', 'new_password'], properties: { current_password: { type: 'string' }, new_password: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Password changed successfully' }, '400': { description: 'Current password incorrect' } },
        },
      },
      '/auth/logout': {
        post: {
          tags: ['Auth'],
          summary: 'Logout (authenticated)',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['refreshToken'], properties: { refreshToken: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Logout successful' }, '401': { description: 'Unauthorized' } },
        },
      },

      // ==================== CATEGORIES (4 endpoints) ====================
      '/categories': {
        get: {
          tags: ['Categories'],
          summary: 'List all categories (public)',
          responses: { '200': { description: 'List of categories' } },
        },
        post: {
          tags: ['Categories'],
          summary: 'Create a new category',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['category_name'], properties: { category_name: { type: 'string' }, parent_id: { type: 'integer', nullable: true } } } } },
          },
          responses: { '201': { description: 'Category created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/categories/{id}': {
        put: {
          tags: ['Categories'],
          summary: 'Update a category',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { category_name: { type: 'string' }, parent_id: { type: 'integer', nullable: true } } } } },
          },
          responses: { '200': { description: 'Category updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Categories'],
          summary: 'Delete a category',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Category deleted' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== SERVICES (5 endpoints) ====================
      '/services': {
        get: {
          tags: ['Services'],
          summary: 'List all services (public)',
          responses: { '200': { description: 'List of services' } },
        },
        post: {
          tags: ['Services'],
          summary: 'Create a new service',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['property_name', 'description', 'price', 'duration'], properties: { property_name: { type: 'string' }, description: { type: 'string' }, price: { type: 'number' }, duration: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'Service created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/services/{id}': {
        put: {
          tags: ['Services'],
          summary: 'Update a service',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { property_name: { type: 'string' }, description: { type: 'string' }, price: { type: 'number' }, duration: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Service updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Services'],
          summary: 'Delete a service',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Service deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/services/{id}/toggle-status': {
        patch: {
          tags: ['Services'],
          summary: 'Toggle service active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== ADDONS (5 endpoints) ====================
      '/addons': {
        get: {
          tags: ['Addons'],
          summary: 'List all add-ons (public)',
          responses: { '200': { description: 'List of add-ons' } },
        },
        post: {
          tags: ['Addons'],
          summary: 'Create a new add-on',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['addon_name', 'parent_id', 'price'], properties: { addon_name: { type: 'string' }, parent_id: { type: 'integer' }, price: { type: 'number' } } } } },
          },
          responses: { '201': { description: 'Add-on created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/addons/{id}': {
        put: {
          tags: ['Addons'],
          summary: 'Update an add-on',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { addon_name: { type: 'string' }, parent_id: { type: 'integer' }, price: { type: 'number' } } } } },
          },
          responses: { '200': { description: 'Add-on updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Addons'],
          summary: 'Delete an add-on',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Add-on deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/addons/{id}/toggle-status': {
        patch: {
          tags: ['Addons'],
          summary: 'Toggle add-on active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== TREATMENTS (4 endpoints) ====================
      '/treatments': {
        get: {
          tags: ['Treatments'],
          summary: 'List all treatments',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of treatments' } },
        },
        post: {
          tags: ['Treatments'],
          summary: 'Create a new treatment',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['name', 'treatment_type'], properties: { name: { type: 'string' }, treatment_type: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Treatment created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/treatments/{id}': {
        put: {
          tags: ['Treatments'],
          summary: 'Update a treatment',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, treatment_type: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Treatment updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Treatments'],
          summary: 'Delete a treatment',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Treatment deleted' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== PROFESSIONALS (5 endpoints) ====================
      '/professionals': {
        get: {
          tags: ['Professionals'],
          summary: 'List all professionals (public)',
          responses: { '200': { description: 'List of professionals' } },
        },
        post: {
          tags: ['Professionals'],
          summary: 'Create a new professional',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['professional_name', 'designation'], properties: { professional_name: { type: 'string' }, designation: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Professional created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/professionals/{id}': {
        put: {
          tags: ['Professionals'],
          summary: 'Update a professional',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { professional_name: { type: 'string' }, designation: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Professional updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Professionals'],
          summary: 'Delete a professional',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Professional deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/professionals/{id}/toggle-status': {
        patch: {
          tags: ['Professionals'],
          summary: 'Toggle professional active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== SLOTS (1 endpoint) ====================
      '/slots': {
        get: {
          tags: ['Slots'],
          summary: 'Get available slots for a professional on a date (public)',
          parameters: [
            { name: 'professional_id', in: 'query', required: true, schema: { type: 'integer' } },
            { name: 'date', in: 'query', required: true, schema: { type: 'string', format: 'date' } },
            { name: 'total_service_duration', in: 'query', required: true, schema: { type: 'integer' } },
          ],
          responses: { '200': { description: 'Available time slots' } },
        },
      },

      // ==================== BOOKINGS (5 endpoints) ====================
      '/bookings': {
        post: {
          tags: ['Bookings'],
          summary: 'Create a new booking (public)',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['service_id', 'profession_id', 'slot_id', 'slot_date', 'first_name', 'last_name', 'email', 'mobile'], properties: { service_id: { type: 'integer' }, profession_id: { type: 'integer' }, slot_id: { type: 'integer' }, slot_date: { type: 'string', format: 'date' }, first_name: { type: 'string' }, last_name: { type: 'string' }, email: { type: 'string', format: 'email' }, mobile: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Booking created' }, '400': { description: 'Validation error' } },
        },
        get: {
          tags: ['Bookings'],
          summary: 'List all bookings (admin)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Paginated list of bookings' } },
        },
      },
      '/bookings/search': {
        get: {
          tags: ['Bookings'],
          summary: 'Search bookings by text (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'search_text', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Search results' } },
        },
      },
      '/bookings/{id}': {
        get: {
          tags: ['Bookings'],
          summary: 'Get booking details by ID (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Booking details' }, '404': { description: 'Not found' } },
        },
      },
      '/bookings/{id}/status': {
        patch: {
          tags: ['Bookings'],
          summary: 'Update booking status (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['status'], properties: { status: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== CUSTOMERS (7 endpoints) ====================
      '/customers/profile': {
        get: {
          tags: ['Customers'],
          summary: 'Get customer profile',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Customer profile data' } },
        },
        put: {
          tags: ['Customers'],
          summary: 'Update customer profile',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { first_name: { type: 'string' }, last_name: { type: 'string' }, mobile: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Profile updated' } },
        },
      },
      '/customers/addresses': {
        get: {
          tags: ['Customers'],
          summary: 'List customer addresses',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of addresses' } },
        },
        post: {
          tags: ['Customers'],
          summary: 'Add a new address',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['address_type', 'country', 'state', 'city', 'address'], properties: { address_type: { type: 'string' }, country: { type: 'string' }, state: { type: 'string' }, city: { type: 'string' }, address: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Address created' } },
        },
      },
      '/customers/addresses/{id}': {
        put: {
          tags: ['Customers'],
          summary: 'Update an address',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { address_type: { type: 'string' }, country: { type: 'string' }, state: { type: 'string' }, city: { type: 'string' }, address: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Address updated' }, '404': { description: 'Not found' } },
        },
      },
      '/customers/bookings': {
        get: {
          tags: ['Customers'],
          summary: 'Get customer booking history',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Booking history' } },
        },
      },
      '/customers/orders': {
        get: {
          tags: ['Customers'],
          summary: 'Get customer order history',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Order history' } },
        },
      },

      // ==================== PAYMENTS (8 endpoints) ====================
      '/payments/stripe/payment-intent': {
        post: {
          tags: ['Payments'],
          summary: 'Create Stripe payment intent',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['amount', 'payment_method_id'], properties: { amount: { type: 'number' }, payment_method_id: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Payment intent created' }, '400': { description: 'Payment failed' } },
        },
      },
      '/payments/stripe/checkout-session': {
        post: {
          tags: ['Payments'],
          summary: 'Create Stripe checkout session',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['amount'], properties: { amount: { type: 'number' } } } } },
          },
          responses: { '200': { description: 'Checkout session created' } },
        },
      },
      '/payments/stripe/webhook': {
        post: {
          tags: ['Payments'],
          summary: 'Stripe webhook handler',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object' } } },
          },
          responses: { '200': { description: 'Webhook processed' } },
        },
      },
      '/payments/stripe/success': {
        get: {
          tags: ['Payments'],
          summary: 'Stripe payment success callback',
          parameters: [{ name: 'session_id', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Payment confirmed' } },
        },
      },
      '/payments/klarna/session': {
        post: {
          tags: ['Payments'],
          summary: 'Create Klarna payment session',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['order_lines'], properties: { order_lines: { type: 'array', items: { type: 'object' } } } } } },
          },
          responses: { '200': { description: 'Klarna session created' } },
        },
      },
      '/payments/klarna/order': {
        post: {
          tags: ['Payments'],
          summary: 'Create Klarna order',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['authorization_token', 'order_data'], properties: { authorization_token: { type: 'string' }, order_data: { type: 'object' } } } } },
          },
          responses: { '200': { description: 'Order created' } },
        },
      },
      '/payments/klarna/authorization/{token}': {
        delete: {
          tags: ['Payments'],
          summary: 'Cancel Klarna authorization',
          parameters: [{ name: 'token', in: 'path', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Authorization cancelled' } },
        },
      },
      '/payments/klarna/session/{id}': {
        get: {
          tags: ['Payments'],
          summary: 'Get Klarna session details',
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Session details' } },
        },
      },

      // ==================== CLINICS (5 endpoints) ====================
      '/clinics': {
        get: {
          tags: ['Clinics'],
          summary: 'List all clinics',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of clinics' } },
        },
        post: {
          tags: ['Clinics'],
          summary: 'Create a new clinic',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['name'], properties: { name: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Clinic created' } },
        },
      },
      '/clinics/{id}': {
        put: {
          tags: ['Clinics'],
          summary: 'Update a clinic',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Clinic updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Clinics'],
          summary: 'Delete a clinic',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Clinic deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/clinics/{id}/toggle-status': {
        patch: {
          tags: ['Clinics'],
          summary: 'Toggle clinic active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },

      // ==================== CONTENT (20 endpoints) ====================
      // --- Banners ---
      '/content/banners': {
        get: {
          tags: ['Content'],
          summary: 'List all banners',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of banners' } },
        },
        post: {
          tags: ['Content'],
          summary: 'Create a new banner',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['title'], properties: { title: { type: 'string' }, image: { type: 'string' }, link: { type: 'string' }, status: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'Banner created' } },
        },
      },
      '/content/banners/{id}': {
        put: {
          tags: ['Content'],
          summary: 'Update a banner',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { title: { type: 'string' }, image: { type: 'string' }, link: { type: 'string' }, status: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Banner updated' } },
        },
        delete: {
          tags: ['Content'],
          summary: 'Delete a banner',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Banner deleted' } },
        },
      },
      '/content/banners/{id}/toggle-status': {
        patch: {
          tags: ['Content'],
          summary: 'Toggle banner active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      // --- Reviews ---
      '/content/reviews': {
        get: {
          tags: ['Content'],
          summary: 'List all reviews',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of reviews' } },
        },
        post: {
          tags: ['Content'],
          summary: 'Create a new review',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['name', 'rating'], properties: { name: { type: 'string' }, rating: { type: 'integer', minimum: 1, maximum: 5 }, review: { type: 'string' }, status: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'Review created' } },
        },
      },
      '/content/reviews/{id}': {
        put: {
          tags: ['Content'],
          summary: 'Update a review',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, rating: { type: 'integer', minimum: 1, maximum: 5 }, review: { type: 'string' }, status: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Review updated' } },
        },
        delete: {
          tags: ['Content'],
          summary: 'Delete a review',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Review deleted' } },
        },
      },
      '/content/reviews/{id}/toggle-status': {
        patch: {
          tags: ['Content'],
          summary: 'Toggle review active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      // --- FAQs ---
      '/content/faqs': {
        get: {
          tags: ['Content'],
          summary: 'List all FAQs',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of FAQs' } },
        },
        post: {
          tags: ['Content'],
          summary: 'Create a new FAQ',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['category_id', 'question'], properties: { category_id: { type: 'integer' }, question: { type: 'string' }, answer: { type: 'string' }, sorting_order: { type: 'integer' }, status: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'FAQ created' } },
        },
      },
      '/content/faqs/{id}': {
        put: {
          tags: ['Content'],
          summary: 'Update a FAQ',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { category_id: { type: 'integer' }, question: { type: 'string' }, answer: { type: 'string' }, sorting_order: { type: 'integer' }, status: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'FAQ updated' } },
        },
        delete: {
          tags: ['Content'],
          summary: 'Delete a FAQ',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'FAQ deleted' } },
        },
      },
      '/content/faqs/{id}/toggle-status': {
        patch: {
          tags: ['Content'],
          summary: 'Toggle FAQ active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      '/content/faqs/sorting': {
        patch: {
          tags: ['Content'],
          summary: 'Update FAQ sort order',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { items: { type: 'array', items: { type: 'object', properties: { id: { type: 'integer' }, sort_order: { type: 'integer' } } } } } } } },
          },
          responses: { '200': { description: 'Sort order updated' } },
        },
      },
      // --- Blogs ---
      '/content/blogs': {
        get: {
          tags: ['Content'],
          summary: 'List all blogs',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of blogs' } },
        },
        post: {
          tags: ['Content'],
          summary: 'Create a new blog post',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['blog_url', 'title'], properties: {
              blog_url: { type: 'string' }, author_name: { type: 'string' },
              meta_title: { type: 'string' }, meta_description: { type: 'string' }, meta_keywords: { type: 'string' }, seo_tags: { type: 'string' },
              title: { type: 'string' }, description: { type: 'string' },
              small_img_name: { type: 'string' }, small_img_alt: { type: 'string' },
              large_img_name: { type: 'string' }, large_img_alt: { type: 'string' },
              title_cn: { type: 'string' }, description_cn: { type: 'string' },
              small_img_name_cn: { type: 'string' }, small_img_alt_cn: { type: 'string' },
              large_img_name_cn: { type: 'string' }, large_img_alt_cn: { type: 'string' },
              title_ar: { type: 'string' }, description_ar: { type: 'string' },
              small_img_name_ar: { type: 'string' }, small_img_alt_ar: { type: 'string' },
              large_img_name_ar: { type: 'string' }, large_img_alt_ar: { type: 'string' },
              blog_category: { type: 'integer' }, status: { type: 'integer' },
            } } } },
          },
          responses: { '201': { description: 'Blog created' } },
        },
      },
      '/content/blogs/{id}': {
        put: {
          tags: ['Content'],
          summary: 'Update a blog post',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: {
              blog_url: { type: 'string' }, author_name: { type: 'string' },
              meta_title: { type: 'string' }, meta_description: { type: 'string' }, meta_keywords: { type: 'string' }, seo_tags: { type: 'string' },
              title: { type: 'string' }, description: { type: 'string' },
              small_img_name: { type: 'string' }, small_img_alt: { type: 'string' },
              large_img_name: { type: 'string' }, large_img_alt: { type: 'string' },
              title_cn: { type: 'string' }, description_cn: { type: 'string' },
              small_img_name_cn: { type: 'string' }, small_img_alt_cn: { type: 'string' },
              large_img_name_cn: { type: 'string' }, large_img_alt_cn: { type: 'string' },
              title_ar: { type: 'string' }, description_ar: { type: 'string' },
              small_img_name_ar: { type: 'string' }, small_img_alt_ar: { type: 'string' },
              large_img_name_ar: { type: 'string' }, large_img_alt_ar: { type: 'string' },
              blog_category: { type: 'integer' }, status: { type: 'integer' },
            } } } },
          },
          responses: { '200': { description: 'Blog updated' } },
        },
        delete: {
          tags: ['Content'],
          summary: 'Delete a blog post',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Blog deleted' } },
        },
      },
      '/content/blogs/{id}/toggle-status': {
        patch: {
          tags: ['Content'],
          summary: 'Toggle blog active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      // --- SEO ---
      '/content/seo': {
        get: {
          tags: ['Content'],
          summary: 'List all SEO entries',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of SEO entries' } },
        },
        post: {
          tags: ['Content'],
          summary: 'Create a new SEO entry',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['page_name'], properties: { page_name: { type: 'string' }, pageurl: { type: 'string' }, meta_title: { type: 'string' }, meta_description: { type: 'string' }, meta_keywords: { type: 'string' }, status: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'SEO entry created' } },
        },
      },
      '/content/seo/{id}': {
        put: {
          tags: ['Content'],
          summary: 'Update a SEO entry',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { page_name: { type: 'string' }, pageurl: { type: 'string' }, meta_title: { type: 'string' }, meta_description: { type: 'string' }, meta_keywords: { type: 'string' }, status: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'SEO entry updated' } },
        },
        delete: {
          tags: ['Content'],
          summary: 'Delete a SEO entry',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'SEO entry deleted' } },
        },
      },

      // ==================== MASTER (1 endpoint) ====================
      '/master/values': {
        get: {
          tags: ['Master'],
          summary: 'Get master values by head (public)',
          parameters: [{ name: 'MasterHead', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Master values for the given head' } },
        },
      },

      // ==================== APPOINTMENTS (5 endpoints) ====================
      '/appointments': {
        post: {
          tags: ['Appointments'],
          summary: 'Create a new appointment',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { patient_id: { type: 'integer' }, professional_id: { type: 'integer' }, appointment_date: { type: 'string', format: 'date-time' }, notes: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Appointment created' } },
        },
        get: {
          tags: ['Appointments'],
          summary: 'List appointments',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of appointments' } },
        },
      },
      '/appointments/{id}': {
        get: {
          tags: ['Appointments'],
          summary: 'Get appointment details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Appointment details' }, '404': { description: 'Not found' } },
        },
      },
      '/appointments/{id}/notes': {
        post: {
          tags: ['Appointments'],
          summary: 'Add notes to an appointment',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { notes: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Notes added' } },
        },
      },
      '/appointments/{id}/logs': {
        post: {
          tags: ['Appointments'],
          summary: 'Add logs to an appointment',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { log_type: { type: 'string' }, description: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Log added' } },
        },
      },

      // ==================== ATTENDANCE (4 endpoints) ====================
      '/attendance/punch-in': {
        post: {
          tags: ['Attendance'],
          summary: 'Punch in (start attendance)',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: false,
            content: { 'application/json': { schema: { type: 'object', properties: { location: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Punch-in recorded' } },
        },
      },
      '/attendance/{id}/punch-out': {
        patch: {
          tags: ['Attendance'],
          summary: 'Punch out (end attendance)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Punch-out recorded' } },
        },
      },
      '/attendance/my': {
        get: {
          tags: ['Attendance'],
          summary: 'Get my attendance records',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Attendance records' } },
        },
      },
      '/attendance': {
        get: {
          tags: ['Attendance'],
          summary: 'List all attendance records (admin)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'All attendance records' } },
        },
      },

      // ==================== PATIENTS (7 endpoints) ====================
      '/patients': {
        post: {
          tags: ['Patients'],
          summary: 'Create a new patient',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { first_name: { type: 'string' }, last_name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, date_of_birth: { type: 'string', format: 'date' } } } } },
          },
          responses: { '201': { description: 'Patient created' } },
        },
        get: {
          tags: ['Patients'],
          summary: 'List all patients',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of patients' } },
        },
      },
      '/patients/{id}': {
        put: {
          tags: ['Patients'],
          summary: 'Update a patient',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { first_name: { type: 'string' }, last_name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Patient updated' }, '404': { description: 'Not found' } },
        },
        get: {
          tags: ['Patients'],
          summary: 'Get patient details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Patient details' }, '404': { description: 'Not found' } },
        },
      },
      '/patients/{id}/timeline': {
        get: {
          tags: ['Patients'],
          summary: 'Get patient timeline',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Patient timeline events' } },
        },
      },
      '/patients/{id}/medical-history': {
        post: {
          tags: ['Patients'],
          summary: 'Save patient medical history',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { history_data: { type: 'object' } } } } },
          },
          responses: { '200': { description: 'Medical history saved' } },
        },
        get: {
          tags: ['Patients'],
          summary: 'Get patient medical history',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Medical history data' } },
        },
      },

      // ==================== LEADS (6 endpoints) ====================
      '/leads': {
        post: {
          tags: ['Leads'],
          summary: 'Create a new lead',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, source: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Lead created' } },
        },
        get: {
          tags: ['Leads'],
          summary: 'List all leads',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of leads' } },
        },
      },
      '/leads/{id}': {
        get: {
          tags: ['Leads'],
          summary: 'Get lead details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Lead details' }, '404': { description: 'Not found' } },
        },
      },
      '/leads/{id}/status': {
        patch: {
          tags: ['Leads'],
          summary: 'Update lead status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['status'], properties: { status: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' } },
        },
      },
      '/leads/{id}/assign': {
        patch: {
          tags: ['Leads'],
          summary: 'Assign lead to employee',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['assigned_to'], properties: { assigned_to: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Lead assigned' } },
        },
      },
      '/leads/{id}/journey': {
        get: {
          tags: ['Leads'],
          summary: 'Get lead journey/history',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Lead journey timeline' } },
        },
      },

      // ==================== CONCERNS (4 endpoints) ====================
      '/concerns/types': {
        get: {
          tags: ['Concerns'],
          summary: 'Get concern types',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of concern types' } },
        },
      },
      '/concerns': {
        get: {
          tags: ['Concerns'],
          summary: 'List all concerns',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of concerns' } },
        },
        post: {
          tags: ['Concerns'],
          summary: 'Create/save a concern',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { patient_id: { type: 'integer' }, concern_type_id: { type: 'integer' }, notes: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Concern saved' } },
        },
      },
      '/concerns/saved/{patientId}': {
        get: {
          tags: ['Concerns'],
          summary: 'Get saved concerns for a patient',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'patientId', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Saved concerns for patient' } },
        },
      },

      // ==================== EMPLOYEES (6 endpoints) ====================
      '/employees': {
        get: {
          tags: ['Employees'],
          summary: 'List all employees',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of employees' } },
        },
        post: {
          tags: ['Employees'],
          summary: 'Create a new employee',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, designation: { type: 'string' }, department: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Employee created' } },
        },
      },
      '/employees/{id}': {
        put: {
          tags: ['Employees'],
          summary: 'Update an employee',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, designation: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Employee updated' }, '404': { description: 'Not found' } },
        },
        get: {
          tags: ['Employees'],
          summary: 'Get employee details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Employee details' }, '404': { description: 'Not found' } },
        },
      },
      '/employees/{id}/toggle-status': {
        patch: {
          tags: ['Employees'],
          summary: 'Toggle employee active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      '/employees/{id}/map': {
        get: {
          tags: ['Employees'],
          summary: 'Get employee service/professional mapping',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Employee mapping data' } },
        },
      },

      // ==================== SKIN CONDITIONS (10 endpoints) ====================
      '/skinconditions': {
        get: {
          tags: ['Skin Conditions'],
          summary: 'List all skin conditions',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of skin conditions' } },
        },
        post: {
          tags: ['Skin Conditions'],
          summary: 'Create a new skin condition',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, description: { type: 'string' }, image_url: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Skin condition created' } },
        },
      },
      '/skinconditions/{id}': {
        put: {
          tags: ['Skin Conditions'],
          summary: 'Update a skin condition',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, description: { type: 'string' }, image_url: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Skin condition updated' } },
        },
        delete: {
          tags: ['Skin Conditions'],
          summary: 'Delete a skin condition',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Skin condition deleted' } },
        },
      },
      '/skinconditions/{id}/toggle-status': {
        patch: {
          tags: ['Skin Conditions'],
          summary: 'Toggle skin condition active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      '/skinconditions/sorting': {
        patch: {
          tags: ['Skin Conditions'],
          summary: 'Update skin conditions sort order',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { items: { type: 'array', items: { type: 'object', properties: { id: { type: 'integer' }, sort_order: { type: 'integer' } } } } } } } },
          },
          responses: { '200': { description: 'Sort order updated' } },
        },
      },
      '/skinconditions/sub': {
        get: {
          tags: ['Skin Conditions'],
          summary: 'List sub skin conditions',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of sub skin conditions' } },
        },
        post: {
          tags: ['Skin Conditions'],
          summary: 'Create a sub skin condition',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, parent_id: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'Sub skin condition created' } },
        },
      },
      '/skinconditions/sub/{id}': {
        put: {
          tags: ['Skin Conditions'],
          summary: 'Update a sub skin condition',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, parent_id: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Sub skin condition updated' } },
        },
        delete: {
          tags: ['Skin Conditions'],
          summary: 'Delete a sub skin condition',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Sub skin condition deleted' } },
        },
      },

      // ==================== CONSULTATION FORMS (4 endpoints) ====================
      '/consultation-forms': {
        get: {
          tags: ['Consultation Forms'],
          summary: 'List all consultation forms',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of consultation forms' } },
        },
      },
      '/consultation-forms/{id}': {
        get: {
          tags: ['Consultation Forms'],
          summary: 'Get consultation form details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Consultation form details' }, '404': { description: 'Not found' } },
        },
      },
      '/consultation-forms/referrals': {
        get: {
          tags: ['Consultation Forms'],
          summary: 'Get referral consultation forms',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Referral forms' } },
        },
      },
      '/consultation-forms/subscribed': {
        get: {
          tags: ['Consultation Forms'],
          summary: 'Get subscribed consultation forms',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Subscribed forms' } },
        },
      },

      // ==================== MEDICAL HISTORY (4 endpoints) ====================
      '/medical-history': {
        get: {
          tags: ['Medical History'],
          summary: 'List medical history templates',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of medical history templates' } },
        },
        post: {
          tags: ['Medical History'],
          summary: 'Create a medical history template',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { title: { type: 'string' }, fields: { type: 'array', items: { type: 'object' } } } } } },
          },
          responses: { '201': { description: 'Template created' } },
        },
      },
      '/medical-history/{id}': {
        put: {
          tags: ['Medical History'],
          summary: 'Update a medical history template',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { title: { type: 'string' }, fields: { type: 'array', items: { type: 'object' } } } } } },
          },
          responses: { '200': { description: 'Template updated' } },
        },
        delete: {
          tags: ['Medical History'],
          summary: 'Delete a medical history template',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Template deleted' } },
        },
      },

      // ==================== TEAMS (5 endpoints) ====================
      '/teams': {
        get: {
          tags: ['Teams'],
          summary: 'List all teams (public)',
          responses: { '200': { description: 'List of teams' } },
        },
        post: {
          tags: ['Teams'],
          summary: 'Create a new team',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, description: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Team created' } },
        },
      },
      '/teams/{id}': {
        put: {
          tags: ['Teams'],
          summary: 'Update a team',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, description: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Team updated' } },
        },
        delete: {
          tags: ['Teams'],
          summary: 'Delete a team',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Team deleted' } },
        },
      },
      '/teams/{id}/toggle-status': {
        patch: {
          tags: ['Teams'],
          summary: 'Toggle team active status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },

      // ==================== SALES CRM (6 endpoints) ====================
      '/sales-crm': {
        get: {
          tags: ['Sales CRM'],
          summary: 'List all sales leads',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of sales leads' } },
        },
        post: {
          tags: ['Sales CRM'],
          summary: 'Create a new sales lead',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, source: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Sales lead created' } },
        },
      },
      '/sales-crm/{id}': {
        get: {
          tags: ['Sales CRM'],
          summary: 'Get sales lead details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Sales lead details' }, '404': { description: 'Not found' } },
        },
      },
      '/sales-crm/{id}/status': {
        patch: {
          tags: ['Sales CRM'],
          summary: 'Update sales lead status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['status'], properties: { status: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' } },
        },
      },
      '/sales-crm/{id}/assign': {
        patch: {
          tags: ['Sales CRM'],
          summary: 'Assign sales lead to employee',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['assigned_to'], properties: { assigned_to: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Lead assigned' } },
        },
      },
      '/sales-crm/{id}/journey': {
        get: {
          tags: ['Sales CRM'],
          summary: 'Get sales lead journey',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Sales lead journey timeline' } },
        },
      },

      // ==================== SELLER CRM (5 endpoints) ====================
      '/seller-crm': {
        get: {
          tags: ['Seller CRM'],
          summary: 'List all seller leads',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of seller leads' } },
        },
        post: {
          tags: ['Seller CRM'],
          summary: 'Create a new seller lead',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, property_details: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Seller lead created' } },
        },
      },
      '/seller-crm/{id}': {
        get: {
          tags: ['Seller CRM'],
          summary: 'Get seller lead details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Seller lead details' }, '404': { description: 'Not found' } },
        },
      },
      '/seller-crm/{id}/status': {
        patch: {
          tags: ['Seller CRM'],
          summary: 'Update seller lead status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['status'], properties: { status: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' } },
        },
      },
      '/seller-crm/{id}/journey': {
        get: {
          tags: ['Seller CRM'],
          summary: 'Get seller lead journey',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Seller lead journey timeline' } },
        },
      },

      // ==================== INVENTORY (6 endpoints) ====================
      '/inventory': {
        get: {
          tags: ['Inventory'],
          summary: 'List all inventory items',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of inventory items' } },
        },
        post: {
          tags: ['Inventory'],
          summary: 'Create a new inventory item',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, category_id: { type: 'integer' }, quantity: { type: 'integer' }, price: { type: 'number' } } } } },
          },
          responses: { '201': { description: 'Inventory item created' } },
        },
      },
      '/inventory/{id}': {
        put: {
          tags: ['Inventory'],
          summary: 'Update an inventory item',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, category_id: { type: 'integer' }, quantity: { type: 'integer' }, price: { type: 'number' } } } } },
          },
          responses: { '200': { description: 'Inventory item updated' } },
        },
        delete: {
          tags: ['Inventory'],
          summary: 'Delete an inventory item',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Inventory item deleted' } },
        },
      },
      '/inventory/categories': {
        get: {
          tags: ['Inventory'],
          summary: 'List inventory categories',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of inventory categories' } },
        },
        post: {
          tags: ['Inventory'],
          summary: 'Create an inventory category',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Inventory category created' } },
        },
      },

      // ==================== VENDORS (4 endpoints) ====================
      '/vendors': {
        get: {
          tags: ['Vendors'],
          summary: 'List all vendors',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of vendors' } },
        },
        post: {
          tags: ['Vendors'],
          summary: 'Create a new vendor',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, address: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Vendor created' } },
        },
      },
      '/vendors/{id}': {
        put: {
          tags: ['Vendors'],
          summary: 'Update a vendor',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, address: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Vendor updated' } },
        },
        delete: {
          tags: ['Vendors'],
          summary: 'Delete a vendor',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Vendor deleted' } },
        },
      },

      // ==================== REDIRECTS (4 endpoints) ====================
      '/redurls': {
        get: {
          tags: ['Redirects'],
          summary: 'List all URL redirects',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of redirects' } },
        },
        post: {
          tags: ['Redirects'],
          summary: 'Create a new URL redirect',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { source_url: { type: 'string' }, destination_url: { type: 'string' }, redirect_type: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'Redirect created' } },
        },
      },
      '/redurls/{id}': {
        put: {
          tags: ['Redirects'],
          summary: 'Update a URL redirect',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { source_url: { type: 'string' }, destination_url: { type: 'string' }, redirect_type: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Redirect updated' } },
        },
        delete: {
          tags: ['Redirects'],
          summary: 'Delete a URL redirect',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Redirect deleted' } },
        },
      },

      // ==================== CLINICAL OPTIONS (4 endpoints) ====================
      '/clinical-options': {
        get: {
          tags: ['Clinical Options'],
          summary: 'List all clinical options',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of clinical options' } },
        },
        post: {
          tags: ['Clinical Options'],
          summary: 'Create a new clinical option',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, type: { type: 'string' }, values: { type: 'array', items: { type: 'string' } } } } } },
          },
          responses: { '201': { description: 'Clinical option created' } },
        },
      },
      '/clinical-options/{id}': {
        put: {
          tags: ['Clinical Options'],
          summary: 'Update a clinical option',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, type: { type: 'string' }, values: { type: 'array', items: { type: 'string' } } } } } },
          },
          responses: { '200': { description: 'Clinical option updated' } },
        },
        delete: {
          tags: ['Clinical Options'],
          summary: 'Delete a clinical option',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Clinical option deleted' } },
        },
      },

      // ==================== NOTIFICATIONS (1 endpoint) ====================
      '/notifications/send': {
        post: {
          tags: ['Notifications'],
          summary: 'Send push notification',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { title: { type: 'string' }, body: { type: 'string' }, user_ids: { type: 'array', items: { type: 'integer' } }, topic: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Notification sent' } },
        },
      },

      // ==================== DASHBOARD (1 endpoint) ====================
      '/dashboard/stats': {
        get: {
          tags: ['Dashboard'],
          summary: 'Get dashboard statistics',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Dashboard statistics data' } },
        },
      },

      // ==================== HOME (1 endpoint) ====================
      '/home': {
        get: {
          tags: ['Home'],
          summary: 'Get home page data',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Home page data' } },
        },
      },

      // ==================== BUYER CRM (5 endpoints) ====================
      '/buyer-crm': {
        get: {
          tags: ['Buyer CRM'],
          summary: 'List all buyer leads',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of buyer leads' } },
        },
        post: {
          tags: ['Buyer CRM'],
          summary: 'Create a new buyer lead',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, budget: { type: 'number' }, requirements: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Buyer lead created' } },
        },
      },
      '/buyer-crm/{id}': {
        get: {
          tags: ['Buyer CRM'],
          summary: 'Get buyer lead details',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Buyer lead details' }, '404': { description: 'Not found' } },
        },
      },
      '/buyer-crm/{id}/status': {
        patch: {
          tags: ['Buyer CRM'],
          summary: 'Update buyer lead status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['status'], properties: { status: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' } },
        },
      },
      '/buyer-crm/{id}/journey': {
        get: {
          tags: ['Buyer CRM'],
          summary: 'Get buyer lead journey',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Buyer lead journey timeline' } },
        },
      },

      // ==================== ATTRIBUTES (9 endpoints) ====================
      '/attributes': {
        get: {
          tags: ['Attributes'],
          summary: 'List all attributes',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of attributes' } },
        },
        post: {
          tags: ['Attributes'],
          summary: 'Create a new attribute',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, type: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Attribute created' } },
        },
      },
      '/attributes/{id}': {
        put: {
          tags: ['Attributes'],
          summary: 'Update an attribute',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, type: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Attribute updated' } },
        },
        delete: {
          tags: ['Attributes'],
          summary: 'Delete an attribute',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Attribute deleted' } },
        },
      },
      '/attributes/values': {
        get: {
          tags: ['Attributes'],
          summary: 'List attribute values',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of attribute values' } },
        },
        post: {
          tags: ['Attributes'],
          summary: 'Create an attribute value',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { attribute_id: { type: 'integer' }, value: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Attribute value created' } },
        },
      },
      '/attributes/values/{id}': {
        put: {
          tags: ['Attributes'],
          summary: 'Update an attribute value',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { attribute_id: { type: 'integer' }, value: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Attribute value updated' } },
        },
        delete: {
          tags: ['Attributes'],
          summary: 'Delete an attribute value',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Attribute value deleted' } },
        },
      },
      '/attributes/map-category': {
        post: {
          tags: ['Attributes'],
          summary: 'Map attribute to category',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { attribute_id: { type: 'integer' }, category_id: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Attribute mapped to category' } },
        },
      },

      // ==================== MOBILE (16 endpoints) ====================
      // --- Brands ---
      '/mobile/brands': {
        get: {
          tags: ['Mobile'],
          summary: 'List all mobile brands',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of brands' } },
        },
        post: {
          tags: ['Mobile'],
          summary: 'Create a new brand',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, logo_url: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Brand created' } },
        },
      },
      '/mobile/brands/{id}': {
        put: {
          tags: ['Mobile'],
          summary: 'Update a brand',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, logo_url: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Brand updated' } },
        },
        delete: {
          tags: ['Mobile'],
          summary: 'Delete a brand',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Brand deleted' } },
        },
      },
      // --- Models ---
      '/mobile/models': {
        get: {
          tags: ['Mobile'],
          summary: 'List all mobile models',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of models' } },
        },
        post: {
          tags: ['Mobile'],
          summary: 'Create a new model',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { brand_id: { type: 'integer' }, name: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Model created' } },
        },
      },
      '/mobile/models/{id}': {
        put: {
          tags: ['Mobile'],
          summary: 'Update a model',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { brand_id: { type: 'integer' }, name: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Model updated' } },
        },
        delete: {
          tags: ['Mobile'],
          summary: 'Delete a model',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Model deleted' } },
        },
      },
      // --- Variants ---
      '/mobile/variants': {
        get: {
          tags: ['Mobile'],
          summary: 'List all mobile variants',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of variants' } },
        },
        post: {
          tags: ['Mobile'],
          summary: 'Create a new variant',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { model_id: { type: 'integer' }, name: { type: 'string' }, storage: { type: 'string' }, ram: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Variant created' } },
        },
      },
      '/mobile/variants/{id}': {
        put: {
          tags: ['Mobile'],
          summary: 'Update a variant',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { model_id: { type: 'integer' }, name: { type: 'string' }, storage: { type: 'string' }, ram: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Variant updated' } },
        },
        delete: {
          tags: ['Mobile'],
          summary: 'Delete a variant',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Variant deleted' } },
        },
      },
      // --- Colours ---
      '/mobile/colours': {
        get: {
          tags: ['Mobile'],
          summary: 'List all mobile colours',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of colours' } },
        },
        post: {
          tags: ['Mobile'],
          summary: 'Create a new colour',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, hex_code: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Colour created' } },
        },
      },
      '/mobile/colours/{id}': {
        put: {
          tags: ['Mobile'],
          summary: 'Update a colour',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, hex_code: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Colour updated' } },
        },
        delete: {
          tags: ['Mobile'],
          summary: 'Delete a colour',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Colour deleted' } },
        },
      },

      // ==================== MOVE DETAILS (5 endpoints) ====================
      '/move-details': {
        get: {
          tags: ['Move Details'],
          summary: 'List all move details',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of move details' } },
        },
        post: {
          tags: ['Move Details'],
          summary: 'Create a move detail entry',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { tenant_id: { type: 'integer' }, property_id: { type: 'integer' }, move_date: { type: 'string', format: 'date' }, type: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Move detail created' } },
        },
      },
      '/move-details/{id}': {
        put: {
          tags: ['Move Details'],
          summary: 'Update a move detail',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { tenant_id: { type: 'integer' }, property_id: { type: 'integer' }, move_date: { type: 'string', format: 'date' }, type: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Move detail updated' } },
        },
        get: {
          tags: ['Move Details'],
          summary: 'Get move detail by ID',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Move detail data' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Move Details'],
          summary: 'Delete a move detail',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Move detail deleted' } },
        },
      },

      // ==================== OWNERS (4 endpoints) ====================
      '/owners': {
        get: {
          tags: ['Owners'],
          summary: 'List all owners',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of owners' } },
        },
        post: {
          tags: ['Owners'],
          summary: 'Create a new owner',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, address: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Owner created' } },
        },
      },
      '/owners/{id}': {
        put: {
          tags: ['Owners'],
          summary: 'Update an owner',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, address: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Owner updated' } },
        },
        delete: {
          tags: ['Owners'],
          summary: 'Delete an owner',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Owner deleted' } },
        },
      },

      // ==================== TENANTS (6 endpoints) ====================
      '/tenants': {
        get: {
          tags: ['Tenants'],
          summary: 'List all tenants',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of tenants' } },
        },
        post: {
          tags: ['Tenants'],
          summary: 'Create a new tenant',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, property_id: { type: 'integer' } } } } },
          },
          responses: { '201': { description: 'Tenant created' } },
        },
      },
      '/tenants/{id}': {
        put: {
          tags: ['Tenants'],
          summary: 'Update a tenant',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' }, property_id: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Tenant updated' } },
        },
        delete: {
          tags: ['Tenants'],
          summary: 'Delete a tenant',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Tenant deleted' } },
        },
      },
      '/tenants/import-template': {
        get: {
          tags: ['Tenants'],
          summary: 'Download tenant import template',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Import template file' } },
        },
      },
      '/tenants/import': {
        post: {
          tags: ['Tenants'],
          summary: 'Import tenants from file',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Tenants imported' }, '400': { description: 'Invalid file' } },
        },
      },

      // ==================== REPORTS (5 endpoints) ====================
      '/reports/customers': {
        get: {
          tags: ['Reports'],
          summary: 'Get customer reports',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Customer report data' } },
        },
      },
      '/reports/emi-list': {
        get: {
          tags: ['Reports'],
          summary: 'Get EMI list report',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'EMI list data' } },
        },
      },
      '/reports/active-emi': {
        get: {
          tags: ['Reports'],
          summary: 'Get active EMI report',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Active EMI data' } },
        },
      },
      '/reports/pending-emi': {
        get: {
          tags: ['Reports'],
          summary: 'Get pending EMI report',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Pending EMI data' } },
        },
      },
      '/reports/bounce-emi': {
        get: {
          tags: ['Reports'],
          summary: 'Get bounce EMI report',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Bounce EMI data' } },
        },
      },

      // ==================== COMMON (3 endpoints) ====================
      '/common/countries': {
        get: {
          tags: ['Common'],
          summary: 'List all countries (public)',
          responses: { '200': { description: 'List of countries' } },
        },
      },
      '/common/states': {
        get: {
          tags: ['Common'],
          summary: 'List states by country (public)',
          parameters: [{ name: 'country_id', in: 'query', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'List of states' } },
        },
      },
      '/common/cities': {
        get: {
          tags: ['Common'],
          summary: 'List cities by state (public)',
          parameters: [{ name: 'state_id', in: 'query', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'List of cities' } },
        },
      },

      // ==================== CRON (1 endpoint) ====================
      '/cron/create-movein-payment': {
        post: {
          tags: ['Cron'],
          summary: 'Create move-in payment (cron trigger)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Move-in payment created' } },
        },
      },

      // ==================== SOCIETIES (4 endpoints) ====================
      '/societies': {
        get: {
          tags: ['Societies'],
          summary: 'List all societies',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of societies' } },
        },
        post: {
          tags: ['Societies'],
          summary: 'Create a new society',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, address: { type: 'string' }, city: { type: 'string' }, state: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Society created' } },
        },
      },
      '/societies/{id}': {
        put: {
          tags: ['Societies'],
          summary: 'Update a society',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, address: { type: 'string' }, city: { type: 'string' }, state: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Society updated' } },
        },
        delete: {
          tags: ['Societies'],
          summary: 'Delete a society',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Society deleted' } },
        },
      },

      // ==================== BUILDERS (4 endpoints) ====================
      '/builders': {
        get: {
          tags: ['Builders'],
          summary: 'List all builders',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of builders' } },
        },
        post: {
          tags: ['Builders'],
          summary: 'Create a new builder',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, contact_person: { type: 'string' }, mobile: { type: 'string' }, email: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Builder created' } },
        },
      },
      '/builders/{id}': {
        put: {
          tags: ['Builders'],
          summary: 'Update a builder',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, contact_person: { type: 'string' }, mobile: { type: 'string' }, email: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Builder updated' } },
        },
        delete: {
          tags: ['Builders'],
          summary: 'Delete a builder',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Builder deleted' } },
        },
      },

      // ==================== DESIGNATIONS (4 endpoints) ====================
      '/designations': {
        get: {
          tags: ['Designations'],
          summary: 'List all designations',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of designations' } },
        },
        post: {
          tags: ['Designations'],
          summary: 'Create a new designation',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, department: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Designation created' } },
        },
      },
      '/designations/{id}': {
        put: {
          tags: ['Designations'],
          summary: 'Update a designation',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, department: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Designation updated' } },
        },
        delete: {
          tags: ['Designations'],
          summary: 'Delete a designation',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Designation deleted' } },
        },
      },

      // ==================== INVENTORY CATEGORIES (5 endpoints) ====================
      '/inventory-categories': {
        get: {
          tags: ['Inventory Categories'],
          summary: 'List all inventory categories',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'List of inventory categories' } },
        },
        post: {
          tags: ['Inventory Categories'],
          summary: 'Create a new inventory category',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, parent_id: { type: 'integer', nullable: true } } } } },
          },
          responses: { '201': { description: 'Inventory category created' } },
        },
      },
      '/inventory-categories/{id}': {
        put: {
          tags: ['Inventory Categories'],
          summary: 'Update an inventory category',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, parent_id: { type: 'integer', nullable: true } } } } },
          },
          responses: { '200': { description: 'Inventory category updated' } },
        },
        delete: {
          tags: ['Inventory Categories'],
          summary: 'Delete an inventory category',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Inventory category deleted' } },
        },
      },
      '/inventory-categories/sub': {
        get: {
          tags: ['Inventory Categories'],
          summary: 'List sub-categories by parent',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'parent_id', in: 'query', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'List of sub-categories' } },
        },
      },

      // ==================== EXPORT (2 endpoints) ====================
      '/export/leads': {
        get: {
          tags: ['Export'],
          summary: 'Export leads data',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Leads export file' } },
        },
      },
      '/export/data': {
        get: {
          tags: ['Export'],
          summary: 'Export general data',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Data export file' } },
        },
      },

      // ==================== IMPORT (7 endpoints) ====================
      '/import/data': {
        post: {
          tags: ['Import'],
          summary: 'Import general data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Data imported' }, '400': { description: 'Invalid file' } },
        },
      },
      '/import/leads': {
        post: {
          tags: ['Import'],
          summary: 'Import leads data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Leads imported' }, '400': { description: 'Invalid file' } },
        },
      },
      '/import/properties': {
        post: {
          tags: ['Import'],
          summary: 'Import properties data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Properties imported' }, '400': { description: 'Invalid file' } },
        },
      },
      '/import/owners': {
        post: {
          tags: ['Import'],
          summary: 'Import owners data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Owners imported' }, '400': { description: 'Invalid file' } },
        },
      },
      '/import/tenants': {
        post: {
          tags: ['Import'],
          summary: 'Import tenants data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Tenants imported' }, '400': { description: 'Invalid file' } },
        },
      },
      '/import/users': {
        post: {
          tags: ['Import'],
          summary: 'Import users data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Users imported' }, '400': { description: 'Invalid file' } },
        },
      },
      '/import/sellers': {
        post: {
          tags: ['Import'],
          summary: 'Import sellers data',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'multipart/form-data': { schema: { type: 'object', properties: { file: { type: 'string', format: 'binary' } } } } },
          },
          responses: { '200': { description: 'Sellers imported' }, '400': { description: 'Invalid file' } },
        },
      },

      // ==================== ORDERS (5 endpoints) ====================
      '/orders': {
        get: {
          tags: ['Orders'],
          summary: 'List all orders (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [
            { name: 'page', in: 'query', schema: { type: 'integer' } },
            { name: 'per_page', in: 'query', schema: { type: 'integer' } },
            { name: 'search', in: 'query', schema: { type: 'string' } },
            { name: 'status', in: 'query', schema: { type: 'string' } },
          ],
          responses: { '200': { description: 'Paginated list of orders' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/orders/{id}': {
        get: {
          tags: ['Orders'],
          summary: 'Get order details by ID (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Order details' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Orders'],
          summary: 'Delete an order (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Order deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/orders/{id}/status': {
        patch: {
          tags: ['Orders'],
          summary: 'Update order status (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['order_status'], properties: { order_status: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' }, '404': { description: 'Not found' } },
        },
      },
      '/orders/{id}/toggle-status': {
        patch: {
          tags: ['Orders'],
          summary: 'Toggle order active status (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== SERVICE CATEGORIES (5 endpoints) ====================
      '/service-categories': {
        get: {
          tags: ['Service Categories'],
          summary: 'List service categories (public). Pass parent_id for sub-levels.',
          parameters: [{ name: 'parent_id', in: 'query', schema: { type: 'integer' } }],
          responses: { '200': { description: 'List of service categories' } },
        },
        post: {
          tags: ['Service Categories'],
          summary: 'Create a service category',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['category_name'], properties: { category_name: { type: 'string' }, parent_id: { type: 'integer' }, description: { type: 'string' }, meta_title: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/service-categories/sorting': {
        post: {
          tags: ['Service Categories'],
          summary: 'Update sorting order',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { items: { type: 'array', items: { type: 'object', properties: { id: { type: 'integer' }, sorting_order: { type: 'integer' } } } } } } } },
          },
          responses: { '200': { description: 'Sorting updated' } },
        },
      },
      '/service-categories/{id}': {
        get: {
          tags: ['Service Categories'],
          summary: 'Get service category by ID',
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Category details' }, '404': { description: 'Not found' } },
        },
        put: {
          tags: ['Service Categories'],
          summary: 'Update a service category',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { category_name: { type: 'string' }, description: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Updated' }, '404': { description: 'Not found' } },
        },
        delete: {
          tags: ['Service Categories'],
          summary: 'Delete a service category',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/service-categories/{id}/toggle-status': {
        patch: {
          tags: ['Service Categories'],
          summary: 'Toggle service category status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== DATA CRM (10 endpoints) ====================
      '/data-crm': {
        get: {
          tags: ['Data CRM'],
          summary: 'List data leads (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [
            { name: 'page', in: 'query', schema: { type: 'integer' } },
            { name: 'per_page', in: 'query', schema: { type: 'integer' } },
            { name: 'status', in: 'query', schema: { type: 'string' } },
            { name: 'assign_emp', in: 'query', schema: { type: 'integer' } },
            { name: 'search', in: 'query', schema: { type: 'string' } },
          ],
          responses: { '200': { description: 'Paginated list of data leads' }, '401': { description: 'Unauthorized' } },
        },
        post: {
          tags: ['Data CRM'],
          summary: 'Create a data lead (admin)',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['name', 'mobile_no'], properties: { name: { type: 'string' }, mobile_no: { type: 'string' }, email: { type: 'string' }, source: { type: 'string' }, message: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Created' }, '401': { description: 'Unauthorized' } },
        },
      },
      '/data-crm/import-logs': {
        get: {
          tags: ['Data CRM'],
          summary: 'List data import logs (admin)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Import logs' } },
        },
      },
      '/data-crm/import-logs/{id}/errors': {
        get: {
          tags: ['Data CRM'],
          summary: 'Get failed records for an import (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Import error records' } },
        },
      },
      '/data-crm/{id}': {
        get: {
          tags: ['Data CRM'],
          summary: 'Get data lead details + journey (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Data details' }, '404': { description: 'Not found' } },
        },
        put: {
          tags: ['Data CRM'],
          summary: 'Update a data lead (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { name: { type: 'string' }, mobile_no: { type: 'string' }, email: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Updated' }, '404': { description: 'Not found' } },
        },
      },
      '/data-crm/{id}/status': {
        patch: {
          tags: ['Data CRM'],
          summary: 'Update data lead status (creates journey entry)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['status'], properties: { status: { type: 'string' }, remark: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Status updated' }, '404': { description: 'Not found' } },
        },
      },
      '/data-crm/{id}/assign': {
        patch: {
          tags: ['Data CRM'],
          summary: 'Assign a data lead to an employee',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['assign_emp'], properties: { assign_emp: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Assigned' }, '404': { description: 'Not found' } },
        },
      },
      '/data-crm/{id}/dead': {
        patch: {
          tags: ['Data CRM'],
          summary: 'Mark a data lead as dead',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Marked dead' }, '404': { description: 'Not found' } },
        },
      },
      '/data-crm/{id}/journey': {
        get: {
          tags: ['Data CRM'],
          summary: 'Get data lead journey timeline',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Journey entries' } },
        },
      },

      // ==================== SUB ADMINS (5 endpoints) ====================
      '/sub-admins': {
        get: {
          tags: ['Sub Admins'],
          summary: 'List sub-admins (admin)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Paginated list' }, '401': { description: 'Unauthorized' } },
        },
        post: {
          tags: ['Sub Admins'],
          summary: 'Create a sub-admin',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['first_name', 'email', 'password'], properties: { first_name: { type: 'string' }, last_name: { type: 'string' }, email: { type: 'string' }, mobile_no: { type: 'string' }, password: { type: 'string' }, menu_permission: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Created' }, '409': { description: 'Email exists' } },
        },
      },
      '/sub-admins/{id}': {
        get: {
          tags: ['Sub Admins'],
          summary: 'Get a sub-admin by ID',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Sub-admin details' }, '404': { description: 'Not found' } },
        },
        put: {
          tags: ['Sub Admins'],
          summary: 'Update a sub-admin',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { first_name: { type: 'string' }, mobile_no: { type: 'string' }, password: { type: 'string' }, menu_permission: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Updated' }, '404': { description: 'Not found' } },
        },
      },
      '/sub-admins/{id}/toggle-status': {
        patch: {
          tags: ['Sub Admins'],
          summary: 'Toggle sub-admin status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== SELLERS (7 endpoints) ====================
      '/sellers': {
        get: {
          tags: ['Sellers'],
          summary: 'List sellers (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [
            { name: 'search', in: 'query', schema: { type: 'string' } },
            { name: 'kyc', in: 'query', schema: { type: 'string', enum: ['Yes', 'No'] } },
          ],
          responses: { '200': { description: 'Paginated list' }, '401': { description: 'Unauthorized' } },
        },
        post: {
          tags: ['Sellers'],
          summary: 'Create a seller',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['first_name', 'email', 'password'], properties: { first_name: { type: 'string' }, email: { type: 'string' }, password: { type: 'string' }, shop_name: { type: 'string' }, shop_gst: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Created' }, '409': { description: 'Email exists' } },
        },
      },
      '/sellers/kyc-list': {
        get: {
          tags: ['Sellers'],
          summary: 'List sellers pending KYC approval',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Pending KYC sellers' } },
        },
      },
      '/sellers/{id}': {
        get: {
          tags: ['Sellers'],
          summary: 'Get a seller by ID',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Seller details' }, '404': { description: 'Not found' } },
        },
        put: {
          tags: ['Sellers'],
          summary: 'Update a seller',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', properties: { first_name: { type: 'string' }, shop_name: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Updated' }, '404': { description: 'Not found' } },
        },
      },
      '/sellers/{id}/toggle-status': {
        patch: {
          tags: ['Sellers'],
          summary: 'Toggle seller status',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' }, '404': { description: 'Not found' } },
        },
      },
      '/sellers/{id}/kyc-approve': {
        patch: {
          tags: ['Sellers'],
          summary: 'Approve/toggle seller KYC',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'KYC updated' }, '404': { description: 'Not found' } },
        },
      },

      // ==================== CART (6 endpoints) ====================
      '/cart': {
        get: {
          tags: ['Cart'],
          summary: 'Get cart contents (public, by session)',
          parameters: [{ name: 'session', in: 'query', schema: { type: 'string' } }],
          responses: { '200': { description: 'Cart items with total' } },
        },
        delete: {
          tags: ['Cart'],
          summary: 'Clear the cart (public, by session)',
          parameters: [{ name: 'session', in: 'query', schema: { type: 'string' } }],
          responses: { '200': { description: 'Cart cleared' } },
        },
      },
      '/cart/add': {
        post: {
          tags: ['Cart'],
          summary: 'Add an item to the cart (public)',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['product_id', 'product_name'], properties: { product_id: { type: 'integer' }, product_name: { type: 'string' }, price: { type: 'number' }, qty: { type: 'integer' }, session: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Item added' } },
        },
      },
      '/cart/{id}/qty': {
        patch: {
          tags: ['Cart'],
          summary: 'Update cart item quantity',
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['qty'], properties: { qty: { type: 'integer' } } } } },
          },
          responses: { '200': { description: 'Quantity updated' }, '404': { description: 'Not found' } },
        },
      },
      '/cart/{id}': {
        delete: {
          tags: ['Cart'],
          summary: 'Remove an item from the cart',
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Item removed' }, '404': { description: 'Not found' } },
        },
      },
      '/cart/checkout': {
        post: {
          tags: ['Cart'],
          summary: 'Checkout the cart into an order (public)',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['first_name', 'email', 'phone'], properties: { first_name: { type: 'string' }, last_name: { type: 'string' }, email: { type: 'string' }, phone: { type: 'string' }, address: { type: 'string' }, payment_method: { type: 'string' }, session: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Order placed' }, '400': { description: 'Cart is empty' } },
        },
      },

      // ==================== SUBSCRIBE (2 endpoints) ====================
      '/subscribe': {
        post: {
          tags: ['Subscribe'],
          summary: 'Submit a subscription (public)',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['email'], properties: { full_name: { type: 'string' }, email: { type: 'string' }, selectedTreatments: { type: 'array', items: { type: 'object' } } } } } },
          },
          responses: { '201': { description: 'Subscribed' } },
        },
        get: {
          tags: ['Subscribe'],
          summary: 'List subscriptions (admin)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Paginated subscriptions' }, '401': { description: 'Unauthorized' } },
        },
      },

      // ==================== COMMON LOOKUPS (extended) ====================
      '/common/master-values': {
        get: {
          tags: ['Common'],
          summary: 'Get master values by head name (e.g. Appointment Type)',
          parameters: [{ name: 'head', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Master values' } },
        },
      },
      '/common/staff': {
        get: {
          tags: ['Common'],
          summary: 'Get active staff members',
          responses: { '200': { description: 'Staff list' } },
        },
      },
      '/common/treatments': {
        get: {
          tags: ['Common'],
          summary: 'Get active treatments',
          responses: { '200': { description: 'Treatments list' } },
        },
      },
      '/common/rooms': {
        get: {
          tags: ['Common'],
          summary: 'Get property/clinic rooms',
          responses: { '200': { description: 'Rooms list' } },
        },
      },
      '/common/static-page': {
        get: {
          tags: ['Common'],
          summary: 'Get static page SEO content by slug',
          parameters: [{ name: 'slug', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Static page content' } },
        },
      },
      '/customers/emis': {
        get: {
          tags: ['Customers'],
          summary: 'Get customer EMI list',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'EMI list' } },
        },
        post: {
          tags: ['Customers'],
          summary: 'Add a customer EMI mandate',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['emi_amount'], properties: { emi_amount: { type: 'number' }, emi_start_date: { type: 'string', format: 'date' }, emi_end_date: { type: 'string', format: 'date' } } } } },
          },
          responses: { '201': { description: 'EMI added' } },
        },
      },
      '/customers/buyers': {
        get: {
          tags: ['Customers'],
          summary: 'List buyers (customers) for the agent app',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Paginated buyer list' } },
        },
      },

      // ==================== PROPERTY (9 endpoints) ====================
      '/properties': {
        get: {
          tags: ['Property'],
          summary: 'List active properties (public)',
          parameters: [
            { name: 'page', in: 'query', schema: { type: 'integer' } },
            { name: 'per_page', in: 'query', schema: { type: 'integer' } },
          ],
          responses: { '200': { description: 'Paginated property list' } },
        },
      },
      '/properties/{id}': {
        get: {
          tags: ['Property'],
          summary: 'Get property details with rooms, images and inventory',
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Property details' }, '404': { description: 'Not found' } },
        },
      },
      '/properties/{id}/rooms': {
        get: {
          tags: ['Property'],
          summary: 'List rooms for a property',
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Room list' } },
        },
      },
      '/properties/{id}/rooms/{roomId}/beds': {
        get: {
          tags: ['Property'],
          summary: 'List beds for a room',
          parameters: [
            { name: 'id', in: 'path', required: true, schema: { type: 'integer' } },
            { name: 'roomId', in: 'path', required: true, schema: { type: 'integer' } },
          ],
          responses: { '200': { description: 'Bed list' } },
        },
      },
      '/properties/admin/all': {
        get: {
          tags: ['Property'],
          summary: 'List all properties (admin)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Paginated list' } },
        },
      },
      '/properties/admin/{id}/rooms': {
        get: {
          tags: ['Property'],
          summary: 'List property rooms (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Rooms' } },
        },
      },
      '/properties/admin/rooms/{roomId}': {
        delete: {
          tags: ['Property'],
          summary: 'Delete a property room (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'roomId', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Deleted' }, '404': { description: 'Not found' } },
        },
      },
      '/properties/admin/{id}/toggle-status': {
        patch: {
          tags: ['Property'],
          summary: 'Toggle property status (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Status toggled' } },
        },
      },
      '/properties/admin/{id}/toggle-offer-status': {
        patch: {
          tags: ['Property'],
          summary: 'Toggle property offer status (admin)',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Offer status toggled' } },
        },
      },

      // ==================== AGENT (11 endpoints) ====================
      '/agent/register': {
        post: {
          tags: ['Agent'],
          summary: 'Register an agent/seller',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['first_name', 'email', 'password'], properties: { first_name: { type: 'string' }, email: { type: 'string' }, mobile_no: { type: 'string' }, password: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Registered, returns token' }, '409': { description: 'Email exists' } },
        },
      },
      '/agent/login': {
        post: {
          tags: ['Agent'],
          summary: 'Agent/seller login',
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['email', 'password'], properties: { email: { type: 'string' }, password: { type: 'string' }, device_token: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Login successful, returns token' }, '401': { description: 'Invalid credentials' } },
        },
      },
      '/agent/device-token': {
        post: {
          tags: ['Agent'],
          summary: 'Update FCM/device token',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['device_token'], properties: { device_token: { type: 'string' } } } } },
          },
          responses: { '200': { description: 'Updated' } },
        },
      },
      '/agent/profile': {
        get: { tags: ['Agent'], summary: 'Get agent profile', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Profile' } } },
        put: { tags: ['Agent'], summary: 'Update agent profile', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Updated' } } },
      },
      '/agent/kyc': {
        get: { tags: ['Agent'], summary: 'Get KYC details', security: [{ BearerAuth: [] }], responses: { '200': { description: 'KYC details' } } },
        put: { tags: ['Agent'], summary: 'Update KYC details', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Updated' } } },
      },
      '/agent/business': {
        get: { tags: ['Agent'], summary: 'Get business details', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Business details' } } },
        put: { tags: ['Agent'], summary: 'Update business details', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Updated' } } },
      },
      '/agent/address': {
        put: { tags: ['Agent'], summary: 'Update agent address', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Updated' } } },
      },
      '/agent/payments': {
        get: { tags: ['Agent'], summary: 'Get agent payments', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Payments' } } },
      },

      // ==================== SALES CRM — FIELD (5 endpoints) ====================
      '/sales-crm/field/schedule-visit': {
        post: {
          tags: ['Sales CRM'],
          summary: 'Field agent schedules a visit for a lead',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['lead_id'], properties: { lead_id: { type: 'integer' }, visit_date: { type: 'string' }, visit_time: { type: 'string' }, builder_id: { type: 'integer' }, society_id: { type: 'integer' }, property_id: { type: 'integer' }, remark: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Visit scheduled' } },
        },
      },
      '/sales-crm/field/token-collected': {
        post: {
          tags: ['Sales CRM'],
          summary: 'Field agent records token collection',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['lead_id'], properties: { lead_id: { type: 'integer' }, token_amount: { type: 'number' }, remark: { type: 'string' } } } } },
          },
          responses: { '201': { description: 'Token collected' } },
        },
        get: {
          tags: ['Sales CRM'],
          summary: 'Leads at the Token Collect stage for the agent',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Lead list' } },
        },
      },
      '/sales-crm/field/schedule-token': {
        get: {
          tags: ['Sales CRM'],
          summary: 'Leads at the Schedule Visit stage for the agent',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Lead list' } },
        },
      },
      '/sales-crm/field/details/{id}': {
        get: {
          tags: ['Sales CRM'],
          summary: 'Lead detail + journey for the field agent',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Lead detail' } },
        },
      },

      // ==================== SELLER CRM — FIELD (3 endpoints) ====================
      '/seller-crm/field/assigned': {
        get: {
          tags: ['Seller CRM'],
          summary: 'Seller leads assigned to the field agent',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Assigned seller leads' } },
        },
      },
      '/seller-crm/field/details/{id}': {
        get: {
          tags: ['Seller CRM'],
          summary: 'Seller lead detail + journey',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Seller lead detail' } },
        },
      },
      '/seller-crm/field/update/{id}': {
        put: {
          tags: ['Seller CRM'],
          summary: 'Field agent updates a seller lead',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Updated' } },
        },
      },

      // ==================== CLINIC — MOBILE (6 endpoints) ====================
      '/clinics/{id}/info': {
        get: { tags: ['Clinics'], summary: 'Clinic info (mobile)', security: [{ BearerAuth: [] }], parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }], responses: { '200': { description: 'Clinic info' } } },
      },
      '/clinics/{id}/hxg': {
        get: { tags: ['Clinics'], summary: 'Clinic hygiene/general card (mobile)', security: [{ BearerAuth: [] }], parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }], responses: { '200': { description: 'Clinic hxg' } } },
      },
      '/clinics/{id}/time': {
        get: { tags: ['Clinics'], summary: 'Clinic opening hours (mobile)', security: [{ BearerAuth: [] }], parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }], responses: { '200': { description: 'Clinic time' } } },
      },
      '/clinics/rooms': {
        get: { tags: ['Clinics'], summary: 'Clinic rooms (mobile)', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Rooms' } } },
      },
      '/clinics/equipments': {
        get: { tags: ['Clinics'], summary: 'Clinic equipment (mobile)', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Equipment' } } },
      },
      '/clinics/finance': {
        get: { tags: ['Clinics'], summary: 'Clinic finance summary (mobile)', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Finance summary' } } },
      },

      // ==================== COMMON — MOBILE LOOKUPS ====================
      '/common/treatment-type': { get: { tags: ['Common'], summary: 'Treatment types (master)', responses: { '200': { description: 'Types' } } } },
      '/common/appointment-type': { get: { tags: ['Common'], summary: 'Appointment types (master)', responses: { '200': { description: 'Types' } } } },
      '/common/equipment': { get: { tags: ['Common'], summary: 'Equipment list (master)', responses: { '200': { description: 'Equipment' } } } },
      '/common/business-type': { get: { tags: ['Common'], summary: 'Business types (master)', responses: { '200': { description: 'Types' } } } },
      '/common/business-category': { get: { tags: ['Common'], summary: 'Business categories (master)', responses: { '200': { description: 'Categories' } } } },
      '/common/help-support': { get: { tags: ['Common'], summary: 'Help & support content', responses: { '200': { description: 'Content' } } } },
      '/common/search': { get: { tags: ['Common'], summary: 'Storefront search', parameters: [{ name: 'q', in: 'query', required: true, schema: { type: 'string' } }], responses: { '200': { description: 'Results' } } } },

      // ==================== ATTENDANCE — LEAVE (2 endpoints) ====================
      '/attendance/leave': {
        post: {
          tags: ['Attendance'],
          summary: 'Add a leave entry',
          security: [{ BearerAuth: [] }],
          requestBody: {
            required: true,
            content: { 'application/json': { schema: { type: 'object', required: ['leave_type', 'leave_date'], properties: { leave_type: { type: 'string' }, day_type: { type: 'string' }, leave_date: { type: 'string', format: 'date' } } } } },
          },
          responses: { '201': { description: 'Leave added' } },
        },
      },
      '/attendance/leave/my': {
        get: { tags: ['Attendance'], summary: 'My leave entries', security: [{ BearerAuth: [] }], responses: { '200': { description: 'Leaves' } } },
      },

      // ==================== PATIENT — FINANCE (1 endpoint) ====================
      '/patients/{id}/finance': {
        get: {
          tags: ['Patients'],
          summary: 'Patient finance summary',
          security: [{ BearerAuth: [] }],
          parameters: [{ name: 'id', in: 'path', required: true, schema: { type: 'integer' } }],
          responses: { '200': { description: 'Finance summary' } },
        },
      },

      // ==================== PAYMENTS — PERSISTENCE FLOWS ====================
      '/payments/stripe/payment-link-shop': {
        post: {
          tags: ['Payments'],
          summary: 'Create a shop checkout session (billing metadata + shipping)',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['amount', 'billing_email'], properties: { amount: { type: 'number' }, billing_first_name: { type: 'string' }, billing_last_name: { type: 'string' }, billing_email: { type: 'string' }, billing_phone: { type: 'string' }, billing_address_1: { type: 'string' }, billing_city: { type: 'string' }, billing_postcode: { type: 'string' }, billing_country: { type: 'string' } } } } } },
          responses: { '200': { description: 'Checkout URL returned' } },
        },
      },
      '/payments/stripe/confirm-order': {
        post: {
          tags: ['Payments'],
          summary: 'Confirm a paid checkout session and persist a shop Order (+ email)',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['session_id'], properties: { session_id: { type: 'string' }, cart_details: { type: 'array', items: { type: 'object' } } } } } } },
          responses: { '201': { description: 'Order placed' }, '400': { description: 'Payment not completed' } },
        },
      },
      '/payments/stripe/confirm-booking': {
        post: {
          tags: ['Payments'],
          summary: 'Confirm a paid checkout session and persist a KiBooking (+ email)',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['session_id'], properties: { session_id: { type: 'string' }, service_id: { type: 'array', items: { type: 'integer' } }, addon_id: { type: 'array', items: { type: 'integer' } }, profession_id: { type: 'integer' }, slot_id: { type: 'integer' }, slot_date: { type: 'string' }, slot_time: { type: 'string' }, first_name: { type: 'string' }, last_name: { type: 'string' }, email: { type: 'string' }, mobile: { type: 'string' } } } } } },
          responses: { '201': { description: 'Booking confirmed' }, '400': { description: 'Payment not completed' } },
        },
      },
      '/payments/stripe/process-payment': {
        post: {
          tags: ['Payments'],
          summary: 'Direct charge that persists a shop Order (+ email)',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['amount', 'payment_method_id'], properties: { amount: { type: 'number' }, payment_method_id: { type: 'string' }, order_amount: { type: 'number' }, billing_email: { type: 'string' }, cart_details: { type: 'array', items: { type: 'object' } } } } } } },
          responses: { '201': { description: 'Payment processed, order created' } },
        },
      },
      '/payments/stripe/booking-payment': {
        post: {
          tags: ['Payments'],
          summary: 'Direct charge that persists a KiBooking (+ email)',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['amount', 'payment_method_id'], properties: { amount: { type: 'number' }, payment_method_id: { type: 'string' }, service_id: { type: 'array', items: { type: 'integer' } }, profession_id: { type: 'integer' }, email: { type: 'string' } } } } } },
          responses: { '201': { description: 'Payment processed, booking created' } },
        },
      },
      '/payments/stripe/apple-pay': {
        post: {
          tags: ['Payments'],
          summary: 'Charge an Apple Pay payment method/token',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['amount', 'payment_method_id'], properties: { amount: { type: 'number' }, payment_method_id: { type: 'string' } } } } } },
          responses: { '200': { description: 'Apple Pay charge processed' } },
        },
      },
      '/payments/klarna/order-web': {
        post: {
          tags: ['Payments'],
          summary: 'Create a Klarna order, fetch billing and persist Customer + Order',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['authorization_token', 'order_amount'], properties: { authorization_token: { type: 'string' }, order_amount: { type: 'number' }, order_lines: { type: 'array', items: { type: 'object' } }, cart_details: { type: 'array', items: { type: 'object' } } } } } } },
          responses: { '201': { description: 'Klarna order created' } },
        },
      },

      // ==================== PUBLIC CONTENT (storefront) ====================
      '/content/public/banners': { get: { tags: ['Content'], summary: 'Public active banners', responses: { '200': { description: 'Banners' } } } },
      '/content/public/reviews': { get: { tags: ['Content'], summary: 'Public active reviews', responses: { '200': { description: 'Reviews' } } } },
      '/content/public/faqs': { get: { tags: ['Content'], summary: 'Public active FAQs', responses: { '200': { description: 'FAQs' } } } },
      '/content/public/blogs': { get: { tags: ['Content'], summary: 'Public active blogs', responses: { '200': { description: 'Blogs' } } } },
      '/content/public/blogs/{slug}': { get: { tags: ['Content'], summary: 'Public blog detail by slug or id', parameters: [{ name: 'slug', in: 'path', required: true, schema: { type: 'string' } }], responses: { '200': { description: 'Blog' } } } },
      '/content/public/seo': { get: { tags: ['Content'], summary: 'Public SEO by page url', parameters: [{ name: 'pageurl', in: 'query', required: true, schema: { type: 'string' } }], responses: { '200': { description: 'SEO' } } } },

      // ==================== BOOKINGS — WEB FILTER ====================
      '/bookings/web': {
        get: {
          tags: ['Bookings'],
          summary: 'List web-submitted bookings (is_web = 1)',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Paginated web bookings' } },
        },
      },

      // ==================== CRON — BIRTHDAY EMAILS ====================
      '/cron/send-birthday-emails': {
        post: {
          tags: ['Cron'],
          summary: 'Send birthday emails to users whose DOB is today',
          security: [{ BearerAuth: [] }],
          responses: { '200': { description: 'Birthday emails sent' } },
        },
      },

      // ==================== SKIN CONDITIONS — SUB SORTING ====================
      '/skinconditions/sub/sorting': {
        patch: {
          tags: ['Skin Conditions'],
          summary: 'Update sub-condition sort order',
          security: [{ BearerAuth: [] }],
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', properties: { items: { type: 'array', items: { type: 'object', properties: { id: { type: 'integer' }, sorting: { type: 'integer' } } } } } } } } },
          responses: { '200': { description: 'Sort order updated' } },
        },
      },

      // ==================== STOREFRONT SELECTION SESSION ====================
      '/storefront/selection': {
        get: {
          tags: ['Storefront'],
          summary: 'Get the current selection (services, addons, products + meta)',
          parameters: [{ name: 'system_id', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Current selection' } },
        },
        delete: {
          tags: ['Storefront'],
          summary: 'Clear the selection session',
          parameters: [{ name: 'system_id', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Cleared' } },
        },
      },
      '/storefront/add-remove-service': {
        post: {
          tags: ['Storefront'],
          summary: 'Toggle a service in the selection',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id', 'sid'], properties: { system_id: { type: 'string' }, sid: { type: 'integer' }, ssession: { type: 'string' }, sprice: { type: 'string' }, cat_id: { type: 'integer' } } } } } },
          responses: { '200': { description: 'Service added/removed' } },
        },
      },
      '/storefront/add-remove-addon': {
        post: {
          tags: ['Storefront'],
          summary: 'Toggle an add-on in the selection',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id', 'sid'], properties: { system_id: { type: 'string' }, sid: { type: 'integer' }, ssession: { type: 'string' }, sprice: { type: 'string' } } } } } },
          responses: { '200': { description: 'Add-on added/removed' } },
        },
      },
      '/storefront/add-remove-product': {
        post: {
          tags: ['Storefront'],
          summary: 'Toggle a product in the selection',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id', 'sid'], properties: { system_id: { type: 'string' }, sid: { type: 'integer' }, sprice: { type: 'string' }, item: { type: 'integer' } } } } } },
          responses: { '200': { description: 'Product added/removed' } },
        },
      },
      '/storefront/professional-time': {
        post: {
          tags: ['Storefront'],
          summary: 'Select a professional and get available slots',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id', 'professional_id'], properties: { system_id: { type: 'string' }, professional_id: { type: 'integer' }, date: { type: 'string', format: 'date' }, total_service_duration: { type: 'integer' } } } } } },
          responses: { '200': { description: 'Professional saved + slots' } },
        },
      },
      '/storefront/update-time-slot': {
        post: {
          tags: ['Storefront'],
          summary: 'Persist the chosen time slot',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id', 'slot_id'], properties: { system_id: { type: 'string' }, slot_id: { type: 'integer' }, slot_date: { type: 'string' }, slot_time: { type: 'string' } } } } } },
          responses: { '200': { description: 'Time slot saved' } },
        },
      },
      '/storefront/save-selected-data': {
        post: {
          tags: ['Storefront'],
          summary: 'Persist selection metadata (professional, slot, addon duration)',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id'], properties: { system_id: { type: 'string' }, professional_id: { type: 'integer' }, slot_id: { type: 'integer' }, slot_date: { type: 'string' }, slot_time: { type: 'string' }, total_addon_duration: { type: 'integer' } } } } } },
          responses: { '200': { description: 'Saved' } },
        },
      },
      '/storefront/change-language': {
        post: {
          tags: ['Storefront'],
          summary: 'Set the session language',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id', 'language'], properties: { system_id: { type: 'string' }, language: { type: 'string' } } } } } },
          responses: { '200': { description: 'Language updated' } },
        },
      },
      '/storefront/hide-popup': {
        post: {
          tags: ['Storefront'],
          summary: 'Mark the intro popup as hidden for the session',
          requestBody: { required: true, content: { 'application/json': { schema: { type: 'object', required: ['system_id'], properties: { system_id: { type: 'string' } } } } } },
          responses: { '200': { description: 'Popup hidden' } },
        },
      },
      '/storefront/search': {
        get: {
          tags: ['Storefront'],
          summary: 'Search active services by name',
          parameters: [{ name: 'q', in: 'query', required: true, schema: { type: 'string' } }],
          responses: { '200': { description: 'Search results' } },
        },
      },

    }, // end paths
  }; // end swaggerSpec

  return swaggerSpec;
}
