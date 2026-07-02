import { z } from 'zod';

// No body validation needed for cron triggers
export const cronTriggerSchema = z.object({}).optional();
