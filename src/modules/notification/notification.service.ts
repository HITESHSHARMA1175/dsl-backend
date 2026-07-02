export class NotificationService {
  async sendPushNotification(deviceTokens: string[], title: string, body: string) {
    // Stub: Log the notification. Actual Firebase integration can be added later.
    console.log('[NotificationService] Push notification sent:', {
      deviceTokens,
      title,
      body,
      sentAt: new Date().toISOString(),
    });

    return {
      message: 'Push notification sent successfully',
      recipients: deviceTokens.length,
    };
  }
}
