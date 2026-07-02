import dotenv from 'dotenv';
dotenv.config();

// Fix BigInt JSON serialization
(BigInt.prototype as any).toJSON = function () {
  return Number(this);
};

// Env validation (throws if invalid)
import { env } from './config/env';

import app from './app';
import { connectDatabase, disconnectDatabase } from './config/database';

async function startServer(): Promise<void> {
  // Try to connect to the DB, but don't crash if it's unreachable — this keeps
  // the API docs (/api-docs) available even before a database is wired up.
  try {
    await connectDatabase();
  } catch (error) {
    console.error('WARNING: database connection failed. Starting server anyway (docs will work; data endpoints will error until DATABASE_URL is reachable).');
    console.error(error instanceof Error ? error.message : error);
  }

  const server = app.listen(env.PORT, () => {
    console.log(`Server running on port ${env.PORT} in ${env.NODE_ENV} mode`);
  });

  // Graceful shutdown handling
  const shutdown = async (signal: string) => {
    console.log(`\n${signal} received. Starting graceful shutdown...`);
    server.close(async () => {
      console.log('HTTP server closed');
      await disconnectDatabase();
      process.exit(0);
    });

    // Force shutdown after 10 seconds if graceful shutdown fails
    setTimeout(() => {
      console.error('Forced shutdown due to timeout');
      process.exit(1);
    }, 10000);
  };

  process.on('SIGTERM', () => shutdown('SIGTERM'));
  process.on('SIGINT', () => shutdown('SIGINT'));
}

startServer().catch((error) => {
  console.error('Failed to start server:', error);
  process.exit(1);
});
