import { Router } from 'express';
import multer from 'multer';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  importData,
  importLeads,
  importProperties,
  importOwners,
  importTenants,
  importUsers,
  importSellers,
} from './import.controller';

const upload = multer({ dest: 'uploads/' });
const router = Router();

router.post('/data', authMiddleware, adminGuard, upload.single('file'), importData);
router.post('/leads', authMiddleware, adminGuard, upload.single('file'), importLeads);
router.post('/properties', authMiddleware, adminGuard, upload.single('file'), importProperties);
router.post('/owners', authMiddleware, adminGuard, upload.single('file'), importOwners);
router.post('/tenants', authMiddleware, adminGuard, upload.single('file'), importTenants);
router.post('/users', authMiddleware, adminGuard, upload.single('file'), importUsers);
router.post('/sellers', authMiddleware, adminGuard, upload.single('file'), importSellers);

export default router;
