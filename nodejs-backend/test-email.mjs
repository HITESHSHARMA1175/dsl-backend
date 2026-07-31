import nodemailer from 'nodemailer';
import dotenv from 'dotenv';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __dirname = dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: join(__dirname, '.env') });

const {
  SMTP_HOST,
  SMTP_PORT,
  SMTP_SECURE,
  SMTP_USER,
  SMTP_PASS,
  SMTP_FROM_EMAIL,
  SMTP_FROM_NAME,
} = process.env;

console.log('🔧 SMTP Config:');
console.log('  HOST :', SMTP_HOST);
console.log('  PORT :', SMTP_PORT);
console.log('  USER :', SMTP_USER);
console.log('  PASS :', SMTP_PASS ? '✅ set (' + SMTP_PASS.length + ' chars)' : '❌ NOT SET');
console.log('  FROM :', SMTP_FROM_EMAIL);
console.log('');

if (!SMTP_HOST || !SMTP_USER || !SMTP_PASS) {
  console.error('❌ SMTP not fully configured. Check .env file.');
  process.exit(1);
}

const transporter = nodemailer.createTransport({
  host: SMTP_HOST,
  port: Number(SMTP_PORT) || 587,
  secure: SMTP_SECURE === 'true',
  connectionTimeout: 10000,
  auth: {
    user: SMTP_USER,
    pass: SMTP_PASS,
  },
});

console.log('📡 Verifying SMTP connection...');
try {
  await transporter.verify();
  console.log('✅ SMTP connection OK!\n');
} catch (err) {
  console.error('❌ SMTP connection FAILED:', err.message);
  process.exit(1);
}

console.log(`📧 Sending test email to: ${SMTP_USER}`);
try {
  const info = await transporter.sendMail({
    from: `"${SMTP_FROM_NAME}" <${SMTP_FROM_EMAIL}>`,
    to: SMTP_USER,
    subject: '✅ DSL Test Email - Order Confirmation Working',
    html: `
      <div style="font-family:Arial,sans-serif;padding:20px;color:#111;">
        <h2>✅ Email Test Successful!</h2>
        <p>Yeh test email hai Diamond Skin London backend se.</p>
        <p><strong>SMTP:</strong> ${SMTP_HOST}:${SMTP_PORT}</p>
        <p><strong>From:</strong> ${SMTP_FROM_EMAIL}</p>
        <p>Order confirmation emails ab kaam karenge! 🎉</p>
        <br/>
        <p>— Diamond Skin London Team</p>
      </div>
    `,
  });

  console.log('✅ Email sent successfully!');
  console.log('   Message ID:', info.messageId);
  console.log(`\n📬 Check inbox: ${SMTP_USER}`);
} catch (err) {
  console.error('❌ Failed to send email:', err.message);
  process.exit(1);
}
