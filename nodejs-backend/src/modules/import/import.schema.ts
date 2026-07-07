import { z } from 'zod';

// File uploads are validated by multer middleware, not by zod
export const importSchema = z.object({}).optional();
