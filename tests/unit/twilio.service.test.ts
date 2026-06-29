jest.mock('axios');
jest.mock('../../src/config/env', () => ({
  env: {
    TWILIO_ACCOUNT_SID: 'AC1234567890abcdef',
    TWILIO_AUTH_TOKEN: 'test-auth-token',
    TWILIO_PHONE_NUMBER: '+15551234567',
  },
}));

import axios from 'axios';
import { TwilioService } from '../../src/shared/services/twilio.service';

const mockedAxios = axios as jest.Mocked<typeof axios>;

describe('TwilioService - configured credentials', () => {
  let service: TwilioService;

  beforeEach(() => {
    service = new TwilioService();
    mockedAxios.post.mockResolvedValue({ status: 201, data: { sid: 'SM123' } });
  });

  afterEach(() => {
    jest.clearAllMocks();
  });

  it('should send an SMS with correct Twilio API parameters', async () => {
    await service.sendSms('+447700900000', 'Your OTP is 1234');

    expect(mockedAxios.post).toHaveBeenCalledTimes(1);
    const [url, body, config] = mockedAxios.post.mock.calls[0];
    expect(url).toBe('https://api.twilio.com/2010-04-01/Accounts/AC1234567890abcdef/Messages.json');
    expect(body).toContain('To=%2B447700900000');
    expect(body).toContain('From=%2B15551234567');
    expect(body).toContain('Body=Your+OTP+is+1234');
    expect(config).toEqual({
      auth: {
        username: 'AC1234567890abcdef',
        password: 'test-auth-token',
      },
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
    });
  });

  it('should use HTTP Basic Auth with account SID and auth token', async () => {
    await service.sendSms('+441234567890', 'Hello');

    const config = mockedAxios.post.mock.calls[0][2] as any;
    expect(config.auth.username).toBe('AC1234567890abcdef');
    expect(config.auth.password).toBe('test-auth-token');
  });

  it('should propagate errors from axios', async () => {
    mockedAxios.post.mockRejectedValueOnce(new Error('Twilio API error'));

    await expect(service.sendSms('+447700900000', 'Hello'))
      .rejects.toThrow('Twilio API error');
  });
});
