jest.mock('axios');
jest.mock('../../src/config/env', () => ({
  env: {
    TWILIO_ACCOUNT_SID: undefined,
    TWILIO_AUTH_TOKEN: undefined,
    TWILIO_PHONE_NUMBER: undefined,
  },
}));

import axios from 'axios';
import { TwilioService } from '../../src/shared/services/twilio.service';

const mockedAxios = axios as jest.Mocked<typeof axios>;

describe('TwilioService - credentials not configured', () => {
  let service: TwilioService;
  let consoleWarnSpy: jest.SpyInstance;

  beforeEach(() => {
    service = new TwilioService();
    consoleWarnSpy = jest.spyOn(console, 'warn').mockImplementation();
  });

  afterEach(() => {
    consoleWarnSpy.mockRestore();
    jest.clearAllMocks();
  });

  it('should log a warning and not call axios when no credentials', async () => {
    await service.sendSms('+447700900000', 'Test message');

    expect(consoleWarnSpy).toHaveBeenCalledWith(
      '[TwilioService] Twilio credentials not configured. SMS not sent.'
    );
    expect(mockedAxios.post).not.toHaveBeenCalled();
  });

  it('should return undefined without throwing', async () => {
    const result = await service.sendSms('+447700900000', 'Test');
    expect(result).toBeUndefined();
  });
});

describe('TwilioService - partial credentials', () => {
  it('should warn when auth token is missing', async () => {
    // Override the env mock for this test
    const envModule = require('../../src/config/env');
    envModule.env.TWILIO_ACCOUNT_SID = 'AC123';
    envModule.env.TWILIO_AUTH_TOKEN = undefined;
    envModule.env.TWILIO_PHONE_NUMBER = '+15551234567';

    const service = new TwilioService();
    const consoleWarnSpy = jest.spyOn(console, 'warn').mockImplementation();

    await service.sendSms('+447700900000', 'Test');

    expect(consoleWarnSpy).toHaveBeenCalledWith(
      '[TwilioService] Twilio credentials not configured. SMS not sent.'
    );
    expect(mockedAxios.post).not.toHaveBeenCalled();

    consoleWarnSpy.mockRestore();
  });
});
