/**
 * Generates a random 4-digit numeric OTP string between 1000 and 9999.
 */
export function generateOtp(): string {
  const otp = Math.floor(1000 + Math.random() * 9000);
  return otp.toString();
}
