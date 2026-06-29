import { PrismaClient } from '@prisma/client';

/**
 * PrismaClient singleton instance with connection pooling.
 * Connection pool size is configured via the DATABASE_URL connection string
 * parameter `connection_limit` (e.g., mysql://...?connection_limit=10).
 *
 * Usage:
 *   import { prisma } from '@config/database';
 *   const users = await prisma.user.findMany();
 */

let prisma: PrismaClient;

declare global {
  // eslint-disable-next-line no-var
  var __prisma: PrismaClient | undefined;
}

function createPrismaClient(): PrismaClient {
  const client = new PrismaClient({
    log:
      process.env.NODE_ENV === 'development'
        ? ['query', 'info', 'warn', 'error']
        : ['error'],
  });
  return client;
}

// Prevent multiple PrismaClient instances in development (hot reloading)
if (process.env.NODE_ENV === 'production') {
  prisma = createPrismaClient();
} else {
  if (!global.__prisma) {
    global.__prisma = createPrismaClient();
  }
  prisma = global.__prisma;
}

/**
 * Connect to the database. Call this during server startup.
 * Logs a success message or throws on connection failure.
 */
async function connectDatabase(): Promise<void> {
  try {
    await prisma.$connect();
    console.log('Database connected successfully');
  } catch (error) {
    console.error('Failed to connect to database:', error);
    throw error;
  }
}

/**
 * Disconnect from the database. Call this during graceful shutdown.
 */
async function disconnectDatabase(): Promise<void> {
  await prisma.$disconnect();
  console.log('Database disconnected');
}

export { prisma, connectDatabase, disconnectDatabase };
