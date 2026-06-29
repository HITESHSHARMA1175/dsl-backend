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

  async createSession(orderData: any) {
    const { data } = await this.client.post('/payments/v1/sessions', orderData);
    return data;
  }

  async createOrder(authorizationToken: string, orderData: any) {
    const { data } = await this.client.post(
      `/payments/v1/authorizations/${authorizationToken}/order`,
      orderData
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
