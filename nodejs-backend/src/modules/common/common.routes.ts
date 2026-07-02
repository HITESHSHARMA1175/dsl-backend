import { Router } from 'express';
import {
  getCountries,
  getStates,
  getCities,
  getMasterValues,
  getStaff,
  getTreatments,
  getRooms,
  getStaticPage,
  getEquipment,
  getAppointmentType,
  getTreatmentType,
  getBusinessTypeList,
  getBusinessCategoryList,
  getHelpSupport,
  search,
} from './common.controller';

const router = Router();

// Public lookup routes
router.get('/countries', getCountries);
router.get('/states', getStates);
router.get('/cities', getCities);
router.get('/master-values', getMasterValues);
router.get('/staff', getStaff);
router.get('/treatments', getTreatments);
router.get('/treatment-type', getTreatmentType);
router.get('/appointment-type', getAppointmentType);
router.get('/equipment', getEquipment);
router.get('/rooms', getRooms);
router.get('/business-type', getBusinessTypeList);
router.get('/business-category', getBusinessCategoryList);
router.get('/static-page', getStaticPage);
router.get('/help-support', getHelpSupport);
router.get('/search', search);

export default router;
