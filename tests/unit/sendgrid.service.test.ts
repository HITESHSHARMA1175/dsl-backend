import axios from 'axios';
import { SendGridService } from '../../src/shared/services/sendgrid.service';

jest.mock('axios');
jest.mock('../../src/config/env', () => ({
  env: {
    SENDGRID_API_KEY: 'test-api-key',
    SENDGRID_FROM_EMAIL: 'test@dslclinic.com',
    SENDGRID_FROM_NAME: 'DSL Clinic',
  },
}));

const mockedAxios = axios as jest.Mocked<typeof axios>;

describe('SendGridService', () => {
  let service: SendGridService;

  beforeEach(() => {
    service = new SendGridService();
    mockedAxios.post.mockResolvedValue({ status: 202 });
  });

  afterEach(() => {
    jest.clearAllMocks();
  });

  describe('sendOtpEmail', () => {
    it('should send an OTP email with correct payload', async () => {
      await service.sendOtpEmail('user@example.com', '1234');

      expect(mockedAxios.post).toHaveBeenCalledWith(
        'https://api.sendgrid.com/v3/mail/send',
        {
          personalizations: [{ to: [{ email: 'user@example.com' }] }],
          from: { email: 'test@dslclinic.com', name: 'DSL Clinic' },
          subject: 'OTP Verification',
          content: [{ type: 'text/html', value: expect.stringContaining('1234') }],
        },
        {
          headers: {
            Authorization: 'Bearer test-api-key',
            'Content-Type': 'application/json',
          },
        }
      );
    });

    it('should include expiry information in OTP email content', async () => {
      await service.sendOtpEmail('user@example.com', '5678');

      const call = mockedAxios.post.mock.calls[0];
      const content = (call[1] as any).content[0].value;
      expect(content).toContain('5678');
      expect(content).toContain('5 minutes');
    });
  });

  describe('sendBookingConfirmation', () => {
    it('should send booking confirmation with correct data', async () => {
      const data = { bookingId: 42, amount: '150.00', date: '2024-01-15', time: '14:00' };

      await service.sendBookingConfirmation('customer@example.com', data);

      expect(mockedAxios.post).toHaveBeenCalledWith(
        'https://api.sendgrid.com/v3/mail/send',
        {
          personalizations: [{ to: [{ email: 'customer@example.com' }] }],
          from: { email: 'test@dslclinic.com', name: 'DSL Clinic' },
          subject: 'DSL Clinic Booking Confirmation',
          content: [{ type: 'text/html', value: expect.stringContaining('42') }],
        },
        expect.any(Object)
      );

      const call = mockedAxios.post.mock.calls[0];
      const htmlContent = (call[1] as any).content[0].value;
      expect(htmlContent).toContain('42');
      expect(htmlContent).toContain('£150.00');
      expect(htmlContent).toContain('2024-01-15');
      expect(htmlContent).toContain('14:00');
    });
  });

  describe('sendOrderConfirmation', () => {
    it('should send order confirmation with correct data', async () => {
      const data = { orderId: 99, amount: '75.50', date: '2024-02-20' };

      await service.sendOrderConfirmation('buyer@example.com', data);

      expect(mockedAxios.post).toHaveBeenCalledWith(
        'https://api.sendgrid.com/v3/mail/send',
        {
          personalizations: [{ to: [{ email: 'buyer@example.com' }] }],
          from: { email: 'test@dslclinic.com', name: 'DSL Clinic' },
          subject: 'DSL Clinic Order Confirmation',
          content: [{ type: 'text/html', value: expect.stringContaining('99') }],
        },
        expect.any(Object)
      );

      const call = mockedAxios.post.mock.calls[0];
      const htmlContent = (call[1] as any).content[0].value;
      expect(htmlContent).toContain('99');
      expect(htmlContent).toContain('£75.50');
      expect(htmlContent).toContain('2024-02-20');
    });
  });

  describe('sendWelcomeEmail', () => {
    it('should send welcome email with user name', async () => {
      await service.sendWelcomeEmail('new@example.com', 'Jane');

      expect(mockedAxios.post).toHaveBeenCalledWith(
        'https://api.sendgrid.com/v3/mail/send',
        {
          personalizations: [{ to: [{ email: 'new@example.com' }] }],
          from: { email: 'test@dslclinic.com', name: 'DSL Clinic' },
          subject: 'Welcome to DSL Clinic',
          content: [{ type: 'text/html', value: expect.stringContaining('Jane') }],
        },
        expect.any(Object)
      );
    });
  });

  describe('error handling', () => {
    it('should propagate errors from axios', async () => {
      mockedAxios.post.mockRejectedValue(new Error('SendGrid API error'));

      await expect(service.sendOtpEmail('user@example.com', '1234'))
        .rejects.toThrow('SendGrid API error');
    });
  });
});
