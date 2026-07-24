import { Router } from 'express';
import { 
  listSlots, 
  createSlot, 
  toggleSlot, 
  deleteSlot, 
  bulkUpdateSlots 
} from './slot.controller';

const router = Router();

// Public routes for slot management
router.get('/', listSlots);
router.post('/', createSlot);
router.put('/bulk', bulkUpdateSlots);
router.put('/:id/toggle', toggleSlot);
router.delete('/:id', deleteSlot);

export default router;
