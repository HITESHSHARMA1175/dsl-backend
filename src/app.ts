import express from 'express';
import cors from 'cors';
import helmet from 'helmet';
import { env } from './config/env';
import { errorHandler } from './middleware/errorHandler.middleware';
import authRoutes from './modules/auth/auth.routes';
import categoryRoutes from './modules/category/category.routes';
import serviceRoutes from './modules/service/service.routes';
import addonRoutes from './modules/addon/addon.routes';
import treatmentRoutes from './modules/treatment/treatment.routes';
import professionalRoutes from './modules/professional/professional.routes';
import slotRoutes from './modules/slot/slot.routes';
import bookingRoutes from './modules/booking/booking.routes';
import customerRoutes from './modules/customer/customer.routes';
import clinicRoutes from './modules/clinic/clinic.routes';
import contentRoutes from './modules/content/content.routes';
import paymentRoutes from './modules/payment/payment.routes';
import masterRoutes from './modules/master/master.routes';

const app = express();

// 1. Security headers
app.use(helmet());

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
app.use('/api/v1/treatments', treatmentRoutes);
app.use('/api/v1/professionals', professionalRoutes);
app.use('/api/v1/slots', slotRoutes);
app.use('/api/v1/bookings', bookingRoutes);
app.use('/api/v1/customers', customerRoutes);
app.use('/api/v1/payments', paymentRoutes);
app.use('/api/v1/clinics', clinicRoutes);
app.use('/api/v1/content', contentRoutes);
app.use('/api/v1/master', masterRoutes);

// 5. Health check
app.get('/health', (_req, res) => {
  res.json({ status: 'ok' });
});

// 6. Global error handler (must be last)
app.use(errorHandler);

export default app;
