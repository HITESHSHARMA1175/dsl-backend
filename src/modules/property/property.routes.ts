import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { adminGuard } from '../../middleware/adminGuard.middleware';
import {
  getProperties,
  getPropertyDetails,
  getPropertyRooms,
  getRoomBeds,
  listAllProperties,
  listPropertyRooms,
  deletePropertyRoom,
  togglePropertyStatus,
  togglePropertyOfferStatus,
} from './property.controller';

const router = Router();

// ----- Admin (place specific paths before param routes) -----
router.get('/admin/all', authMiddleware, adminGuard, listAllProperties);
router.get('/admin/:id/rooms', authMiddleware, adminGuard, listPropertyRooms);
router.delete('/admin/rooms/:roomId', authMiddleware, adminGuard, deletePropertyRoom);
router.patch('/admin/:id/toggle-status', authMiddleware, adminGuard, togglePropertyStatus);
router.patch('/admin/:id/toggle-offer-status', authMiddleware, adminGuard, togglePropertyOfferStatus);

// ----- Public / mobile -----
router.get('/', getProperties);
router.get('/:id', getPropertyDetails);
router.get('/:id/rooms', getPropertyRooms);
router.get('/:id/rooms/:roomId/beds', getRoomBeds);

export default router;
