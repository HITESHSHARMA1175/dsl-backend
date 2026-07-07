import axios from 'axios';
import { env } from '../../config/env';

export class TwilioService {
  private accountSid: string | undefined;
  private authToken: string | undefined;
  private fromNumber: string | undefined;

  constructor() {
    this.accountSid = env.TWILIO_ACCOUNT_SID;
    this.authToken = env.TWILIO_AUTH_TOKEN;
    this.fromNumber = env.TWILIO_PHONE_NUMBER;
  }

  /**
   * Send an SMS message via the Twilio REST API.
   * If Twilio credentials are not configured, logs a warning and returns without sending.
   */
  async sendSms(to: string, message: string): Promise<void> {
    if (!this.accountSid || !this.authToken || !this.fromNumber) {
      console.warn('[TwilioService] Twilio credentials not configured. SMS not sent.');
      return;
    }

    const url = `https://api.twilio.com/2010-04-01/Accounts/${this.accountSid}/Messages.json`;

    const params = new URLSearchParams();
    params.append('To', to);
    params.append('From', this.fromNumber);
    params.append('Body', message);

    await axios.post(url, params.toString(), {
      auth: {
        username: this.accountSid,
        password: this.authToken,
      },
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
    });
  }
}
