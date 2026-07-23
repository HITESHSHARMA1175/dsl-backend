import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import path from 'path';
import fs from 'fs';
import swaggerUi from 'swagger-ui-express';
import { env } from './config/env';
import { generateSwaggerSpec } from './config/swagger';
import { errorHandler } from './middleware/errorHandler.middleware';
import authRoutes from './modules/auth/auth.routes';
import categoryRoutes from './modules/category/category.routes';
import serviceRoutes from './modules/service/service.routes';
import addonRoutes from './modules/addon/addon.routes';
import treatmentRoutes from './modules/treatment/treatment.routes';
import treatmentsPublicRoutes from './modules/treatments/treatments.routes';
import professionalRoutes from './modules/professional/professional.routes';
import slotRoutes from './modules/slot/slot.routes';
import bookingRoutes from './modules/booking/booking.routes';
import customerRoutes from './modules/customer/customer.routes';
import clinicRoutes from './modules/clinic/clinic.routes';
import contentRoutes from './modules/content/content.routes';
import paymentRoutes from './modules/payment/payment.routes';
import masterRoutes from './modules/master/master.routes';
import appointmentRoutes from './modules/appointment/appointment.routes';
import attendanceRoutes from './modules/attendance/attendance.routes';
import patientRoutes from './modules/patient/patient.routes';
import leadRoutes from './modules/lead/lead.routes';
import concernRoutes from './modules/concern/concern.routes';
import employeeRoutes from './modules/employee/employee.routes';
import skinconditionRoutes from './modules/skincondition/skincondition.routes';
import consultationformRoutes from './modules/consultationform/consultationform.routes';
import medicalhistoryRoutes from './modules/medicalhistory/medicalhistory.routes';
import teamRoutes from './modules/team/team.routes';
import salescrmRoutes from './modules/salescrm/salescrm.routes';
import sellercrmRoutes from './modules/sellercrm/sellercrm.routes';
import inventoryRoutes from './modules/inventory/inventory.routes';
import vendorRoutes from './modules/vendor/vendor.routes';
import redurlRoutes from './modules/redurl/redurl.routes';
import clinicaloptionRoutes from './modules/clinicaloption/clinicaloption.routes';
import notificationRoutes from './modules/notification/notification.routes';
import dashboardRoutes from './modules/dashboard/dashboard.routes';
import homeRoutes from './modules/home/home.routes';
import buyercrmRoutes from './modules/buyercrm/buyercrm.routes';
import attributeRoutes from './modules/attribute/attribute.routes';
import mobileRoutes from './modules/mobile/mobile.routes';
import movedetailRoutes from './modules/movedetail/movedetail.routes';
import ownerRoutes from './modules/owner/owner.routes';
import tenantRoutes from './modules/tenant/tenant.routes';
import reportRoutes from './modules/report/report.routes';
import commonRoutes from './modules/common/common.routes';
import cronRoutes from './modules/cron/cron.routes';
import societyRoutes from './modules/society/society.routes';
import builderRoutes from './modules/builder/builder.routes';
import designationRoutes from './modules/designation/designation.routes';
import inventorycategoryRoutes from './modules/inventorycategory/inventorycategory.routes';
import exportRoutes from './modules/export/export.routes';
import importRoutes from './modules/import/import.routes';
import orderRoutes from './modules/order/order.routes';
import servicecatRoutes from './modules/servicecat/servicecat.routes';
import datacrmRoutes from './modules/datacrm/datacrm.routes';
import subadminRoutes from './modules/subadmin/subadmin.routes';
import sellerRoutes from './modules/seller/seller.routes';
import cartRoutes from './modules/cart/cart.routes';
import subscribeRoutes from './modules/subscribe/subscribe.routes';
import propertyRoutes from './modules/property/property.routes';
import agentRoutes from './modules/agent/agent.routes';
import storefrontRoutes from './modules/storefront/storefront.routes';
import uploadRoutes from './modules/upload/upload.routes';
import treatmentpageRoutes from './modules/treatmentpage/treatmentpage.routes';
import shopProductRoutes from './modules/shopproduct/shopproduct.routes';
import offerRoutes from './modules/offer/offer.routes';

const app = express();

// 1. Security headers
// crossOriginResourcePolicy defaults to 'same-origin', which blocks the
// frontend (a different origin) from loading <img> tags pointing at
// /uploads/* - the API is meant to be consumed cross-origin (CORS_ORIGINS
// is '*'), so resources need to be too.
app.use(helmet({
  crossOriginResourcePolicy: { policy: 'cross-origin' },
  contentSecurityPolicy: {
    directives: {
      ...helmet.contentSecurityPolicy.getDefaultDirectives(),
      'img-src': ["'self'", 'data:', 'https:'],
    },
  },
}));

// 2. CORS
app.use(cors({
  origin: env.CORS_ORIGINS === '*' ? '*' : env.CORS_ORIGINS.split(','),
}));

// 3. Body parsing (raw for Stripe webhooks, JSON for everything else)
app.use('/api/v1/payments/stripe/webhook', express.raw({ type: 'application/json' }));
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));

// 4. API routes
app.use('/api/v1/auth', authRoutes);
app.use('/api/v1/categories', categoryRoutes);
app.use('/api/v1/services', serviceRoutes);
app.use('/api/v1/addons', addonRoutes);
// New public contract routes (navbar/:slug) first; legacy admin-only treatment
// CRUD (/, /:id) falls through to the second router untouched since Express
// routers call next() when nothing matches.
app.use('/api/v1/treatments', treatmentsPublicRoutes);
app.use('/api/v1/treatments', treatmentRoutes);
app.use('/api/v1/professionals', professionalRoutes);
app.use('/api/v1/slots', slotRoutes);
app.use('/api/v1/bookings', bookingRoutes);
app.use('/api/v1/customers', customerRoutes);
app.use('/api/v1/payments', paymentRoutes);
app.use('/api/v1/clinics', clinicRoutes);
app.use('/api/v1/content', contentRoutes);
app.use('/api/v1/master', masterRoutes);
app.use('/api/v1/appointments', appointmentRoutes);
app.use('/api/v1/attendance', attendanceRoutes);
app.use('/api/v1/patients', patientRoutes);
app.use('/api/v1/leads', leadRoutes);
app.use('/api/v1/concerns', concernRoutes);
app.use('/api/v1/employees', employeeRoutes);
app.use('/api/v1/skinconditions', skinconditionRoutes);
app.use('/api/v1/consultation-forms', consultationformRoutes);
app.use('/api/v1/medical-history', medicalhistoryRoutes);
app.use('/api/v1/teams', teamRoutes);
app.use('/api/v1/sales-crm', salescrmRoutes);
app.use('/api/v1/seller-crm', sellercrmRoutes);
app.use('/api/v1/inventory', inventoryRoutes);
app.use('/api/v1/vendors', vendorRoutes);
app.use('/api/v1/redurls', redurlRoutes);
app.use('/api/v1/clinical-options', clinicaloptionRoutes);
app.use('/api/v1/notifications', notificationRoutes);
app.use('/api/v1/dashboard', dashboardRoutes);
app.use('/api/v1/home', homeRoutes);
app.use('/api/v1/buyer-crm', buyercrmRoutes);
app.use('/api/v1/attributes', attributeRoutes);
app.use('/api/v1/mobile', mobileRoutes);
app.use('/api/v1/move-details', movedetailRoutes);
app.use('/api/v1/owners', ownerRoutes);
app.use('/api/v1/tenants', tenantRoutes);
app.use('/api/v1/reports', reportRoutes);
app.use('/api/v1/common', commonRoutes);
app.use('/api/v1/cron', cronRoutes);
app.use('/api/v1/societies', societyRoutes);
app.use('/api/v1/builders', builderRoutes);
app.use('/api/v1/designations', designationRoutes);
app.use('/api/v1/inventory-categories', inventorycategoryRoutes);
app.use('/api/v1/export', exportRoutes);
app.use('/api/v1/import', importRoutes);
app.use('/api/v1/orders', orderRoutes);
app.use('/api/v1/service-categories', servicecatRoutes);
app.use('/api/v1/data-crm', datacrmRoutes);
app.use('/api/v1/sub-admins', subadminRoutes);
app.use('/api/v1/sellers', sellerRoutes);
app.use('/api/v1/cart', cartRoutes);
app.use('/api/v1/subscribe', subscribeRoutes);
app.use('/api/v1/properties', propertyRoutes);
app.use('/api/v1/agent', agentRoutes);
app.use('/api/v1/storefront', storefrontRoutes);
app.use('/api/v1/upload', uploadRoutes);
app.use('/api/v1/treatment-pages', treatmentpageRoutes);
app.use('/api/v1/shop-products', shopProductRoutes);
app.use('/api/v1/offers', offerRoutes);


// Serve uploaded images. NOTE: Render's filesystem is ephemeral — anything
// written here is wiped on every deploy/restart. This is a temporary local
// setup until uploads move to S3/Cloudinary.
const uploadsDir = path.join(__dirname, '..', 'uploads');
fs.mkdirSync(uploadsDir, { recursive: true });
app.use('/uploads', express.static(uploadsDir));

// 5. Swagger API Documentation (auto-generated from routes)
const swaggerSpec = generateSwaggerSpec(app);

// Raw OpenAPI JSON — shareable / importable into Postman, Insomnia, Swagger Editor
app.get('/api-docs.json', (_req, res) => {
  res.json(swaggerSpec);
});

app.use('/api-docs', swaggerUi.serve, swaggerUi.setup(swaggerSpec, {
  customCss: '.swagger-ui .topbar { display: none }',
  customSiteTitle: 'DSL Clinic API Docs',
}));

// 6. Health check
app.get('/health', (_req, res) => {
  res.json({ status: 'ok' });
});

// 6. Global error handler (must be last)
app.use(errorHandler);

export default app;
