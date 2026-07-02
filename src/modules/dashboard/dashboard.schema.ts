import { z } from 'zod';

// Dashboard is read-only, no input schemas needed
// Keeping schema file for consistency

export const dashboardQuerySchema = z.object({}).optional();
