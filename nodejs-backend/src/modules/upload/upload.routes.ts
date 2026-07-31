import { Router } from 'express';
import multer from 'multer';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import { AppError } from '../../shared/utils/appError';
import { uploadImage } from './upload.controller';

const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

const upload = multer({
  storage: multer.memoryStorage(),
  limits: { fileSize: 5 * 1024 * 1024 }, // 5MB
  fileFilter: (_req, file, cb) => {
    if (!ALLOWED_MIME_TYPES.includes(file.mimetype)) {
      return cb(new AppError(400, 'Only JPEG, PNG, WEBP, and GIF images are allowed'));
    }
    cb(null, true);
  },
});

const router = Router();

router.post('/', authMiddleware, adminGuard, upload.single('image'), uploadImage);

export default router;
