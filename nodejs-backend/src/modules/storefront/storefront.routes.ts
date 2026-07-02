import { Router } from 'express';
import {
  getSelection,
  addRemoveService,
  addRemoveAddon,
  addRemoveProduct,
  professionalTime,
  updateTimeSlot,
  saveSelectedData,
  changeLanguage,
  hidePopup,
  clearSelection,
  searchServices,
} from './storefront.controller';

const router = Router();

// Public storefront selection-session endpoints (keyed by system_id)
router.get('/selection', getSelection);
router.post('/add-remove-service', addRemoveService);
router.post('/add-remove-addon', addRemoveAddon);
router.post('/add-remove-product', addRemoveProduct);
router.post('/professional-time', professionalTime);
router.post('/update-time-slot', updateTimeSlot);
router.post('/save-selected-data', saveSelectedData);
router.post('/change-language', changeLanguage);
router.post('/hide-popup', hidePopup);
router.delete('/selection', clearSelection);
router.get('/search', searchServices);

export default router;
