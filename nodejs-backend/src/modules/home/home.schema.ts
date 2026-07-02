import { z } from 'zod';

// Home page is read-only, no input schemas needed
// Keeping schema file for consistency

export const homeQuerySchema = z.object({}).optional();
