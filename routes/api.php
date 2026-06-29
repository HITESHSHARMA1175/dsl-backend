<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes 
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// new apis kiosk
Route::post('ki_get_categories', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'ki_get_categories'])->name('ki_get_categories');
Route::post('ki_get_services', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'ki_get_services'])->name('ki_get_services');
Route::post('ki_get_addon_services', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'ki_get_addon_services'])->name('ki_get_addon_services');
Route::post('ki_get_addon_categories', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'ki_get_addon_categories'])->name('ki_get_addon_categories');
Route::post('get_professionals', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_professionals'])->name('get_professionals');
Route::post('get_latter_slots', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_latter_slots'])->name('get_latter_slots');
Route::post('get_next_slots', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_next_slots'])->name('get_next_slots');
Route::post('add_ki_booking', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'add_ki_booking'])->name('add_ki_booking');
Route::post('search_ki_booking', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'search_ki_booking'])->name('search_ki_booking');
Route::post('get_app_slots', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_app_slots'])->name('get_app_slots');

Route::post('get_staff', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_staff'])->name('get_staff');
Route::post('get_all_patient', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_all_patient'])->name('get_all_patient');
Route::post('get_patient', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_patient'])->name('get_patient');
Route::post('get_appointment_type', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_appointment_type'])->name('get_appointment_type');
Route::post('get_treatment_type', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_treatment_type'])->name('get_treatment_type');
Route::post('get_treatment', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_treatment'])->name('get_treatment');
Route::post('get_room', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_room'])->name('get_room');
Route::post('get_equipment', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'get_equipment'])->name('get_equipment');
//Route::post('ki_get_addon_services', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'ki_get_addon_services'])->name('ki_get_addon_services');

Route::get('customerLogin', [App\Http\Controllers\Api\LoginControllerInApi::class, 'customerLogin'])->name('customerLogin');
Route::post('updateCustomerToken', [App\Http\Controllers\Api\LoginControllerInApi::class, 'updateCustomerToken'])->name('updateCustomerToken');

Route::post('userRegister', [App\Http\Controllers\Api\LoginControllerInApi::class, 'userRegister'])->name('userRegister');
Route::post('userLogin', [App\Http\Controllers\Api\LoginControllerInApi::class, 'userLogin'])->name('userLogin');

Route::group(['middleware' => 'auth:sanctum'], function () {
    
    Route::post('save_medical_history', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'save_medical_history'])->name('save_medical_history');
    
    // new apis reserve
    Route::post('add_patient', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'add_patient'])->name('add_patient');
    Route::post('update_patient', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'update_patient'])->name('update_patient');
    
    Route::post('medicle_history_patient', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'medicle_history_patient'])->name('medicle_history_patient');
    
    Route::post('get_concern_type', [App\Http\Controllers\Api\Concern\ConcernControllerInApi::class, 'get_concern_type'])->name('get_concern_type');
    Route::post('get_concern', [App\Http\Controllers\Api\Concern\ConcernControllerInApi::class, 'get_concern'])->name('get_concern');
    Route::post('save_concern', [App\Http\Controllers\Api\Concern\ConcernControllerInApi::class, 'save_concern'])->name('save_concern');
    Route::post('get_saved_concern', [App\Http\Controllers\Api\Concern\ConcernControllerInApi::class, 'get_saved_concern'])->name('get_saved_concern');
   
    
    Route::post('create_appointment', [App\Http\Controllers\Api\Appointment\AppointmentControllerInApi::class, 'create_appointment'])->name('create_appointment');
    Route::post('get_appointment', [App\Http\Controllers\Api\Appointment\AppointmentControllerInApi::class, 'get_appointment'])->name('get_appointment');
    Route::post('get_appointment_details', [App\Http\Controllers\Api\Appointment\AppointmentControllerInApi::class, 'get_appointment_details'])->name('get_appointment_details');
    Route::post('add_appointment_notes', [App\Http\Controllers\Api\Appointment\AppointmentControllerInApi::class, 'add_appointment_notes'])->name('add_appointment_notes');
    Route::post('add_appointment_logs', [App\Http\Controllers\Api\Appointment\AppointmentControllerInApi::class, 'add_appointment_logs'])->name('add_appointment_logs');
    
    Route::post('get_clinic', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic'])->name('get_clinic');
    Route::post('get_all_clinic', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_all_clinic'])->name('get_all_clinic');
    Route::post('get_clinic_info', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic_info'])->name('get_clinic_info');
    Route::post('get_clinic_hxg', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic_hxg'])->name('get_clinic_hxg');
    Route::post('get_clinic_rooms', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic_rooms'])->name('get_clinic_rooms');
    Route::post('get_clinic_equipments', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic_equipments'])->name('get_clinic_equipments');
    Route::post('get_clinic_time', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic_time'])->name('get_clinic_time');
    Route::post('get_clinic_finance', [App\Http\Controllers\Api\Clinic\ClinicControllerInApi::class, 'get_clinic_finance'])->name('get_clinic_finance');
    
    Route::post('get_patient_timeline', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'get_patient_timeline'])->name('get_patient_timeline');
    Route::post('get_patient_info', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'get_patient_info'])->name('get_patient_info');
    Route::post('get_patient_finance', [App\Http\Controllers\Api\Patient\PatientControllerInApi::class, 'get_patient_finance'])->name('get_patient_finance');
    
    Route::post('homePage', [App\Http\Controllers\Api\Home\HomeControllerInApi::class, 'homePage'])->name('homePage');
    
    
    Route::post('emiList', [App\Http\Controllers\Api\Customer\CustomerControllerInApi::class, 'emiList'])->name('emiList');
    Route::post('buyerList', [App\Http\Controllers\Api\Customer\CustomerControllerInApi::class, 'buyerList'])->name('buyerList');
    Route::post('addMandate', [App\Http\Controllers\Api\Customer\CustomerControllerInApi::class, 'addMandate'])->name('addMandate');
    Route::post('addMandate2', [App\Http\Controllers\Api\Customer\CustomerControllerInApi::class, 'addMandate2'])->name('addMandate2');
    Route::post('customerEmi', [App\Http\Controllers\Api\Customer\CustomerControllerInApi::class, 'customerEmi'])->name('customerEmi');
    
    Route::post('myProfile', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'myProfile'])->name('myProfile');
    Route::post('kycDetails', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'kycDetails'])->name('kycDetails');
    Route::post('updateKyc', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'updateKyc'])->name('updateKyc');
    Route::post('updateBusinessName', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'updateBusinessName'])->name('updateBusinessName');
    Route::post('getBusinessName', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'getBusinessName'])->name('getBusinessName');
    Route::post('updateUserAddress', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'updateUserAddress'])->name('updateUserAddress');
    Route::post('myPayment', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'myPayment'])->name('myPayment');
    Route::post('updateProfile', [App\Http\Controllers\Api\User\UserControllerInApi::class, 'updateProfile'])->name('updateProfile');
    
    
    
});


//common api
Route::post('getBrand', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getBrand'])->name('getBrand');
Route::post('getModel', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getModel'])->name('getModel');
Route::post('getVariant', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getVariant'])->name('getVariant');
Route::post('getColour', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getColour'])->name('getColour');

Route::post('getState', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getState'])->name('getState');
Route::post('getCity', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getCity'])->name('getCity');
Route::post('businessTypeList', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'businessTypeList'])->name('businessTypeList');
Route::post('businessCategoryList', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'businessCategoryList'])->name('businessCategoryList');

Route::post('staticPage', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'staticPage'])->name('staticPage');
Route::post('getHelpSupport', [App\Http\Controllers\Api\Common\CommonControllerInApi::class, 'getHelpSupport'])->name('getHelpSupport');
