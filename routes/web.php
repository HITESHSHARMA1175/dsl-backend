<?php

use Illuminate\Support\Facades\Route;

/*  
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('admin.login');
// });
/*Route::get('/clear-cache', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('route:clear');
    \Artisan::call('optimize:clear');


    return 'Cache cleared successfully';
});*/

use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\KlarnaController;

use App\Http\Controllers\StripeController;

use App\Http\Controllers\StripePaymentController;

use App\Http\Controllers\KlarnaPaymentController;


use App\Http\Controllers\PaymentController;


use App\Http\Controllers\KlarnaApiController;

use App\Http\Controllers\EmailApiTestController;


Route::get('/emailapitest', [EmailApiTestController::class, 'index'])->name('emailapitest.index');
Route::post('/emailapitest/send', [EmailApiTestController::class, 'send'])->name('emailapitest.send');
Route::post('/emailapitest/send-otp', [EmailApiTestController::class, 'sendOtpMail'])->name('emailapitest.sendOtp');
Route::post('/emailapitest/send-order', [EmailApiTestController::class, 'sendOrderMail'])->name('emailapitest.sendOrder');
Route::post('/emailapitest/send-booking', [EmailApiTestController::class, 'sendBookingMail'])->name('emailapitest.sendBooking');
Route::get('/emailapitest/send-birthday', [EmailApiTestController::class, 'sendBirthdayMail'])->name('emailapitest.sendBirthday');
Route::post('/emailapitest/send-welcome', [EmailApiTestController::class, 'sendWelcomeMail'])->name('emailapitest.sendWelcome');



//klarna payment routes start

Route::view('/klarna-test', 'klarna.test');

Route::prefix('klarna')->group(function () {
    Route::post('session', [KlarnaApiController::class, 'createSession']);
    Route::post('order/{token}', [KlarnaApiController::class, 'createOrder']);
    Route::delete('authorization/{token}', [KlarnaApiController::class, 'cancelAuth']);
    Route::get('session/{id}', [KlarnaApiController::class, 'getSession']);
    Route::get('order-success/{id}', [KlarnaApiController::class, 'orderSuccess']);
    Route::get('booking-success/{id}', [KlarnaApiController::class, 'bookingSuccess']);
});

//klarna payment routes end
Route::get('/mail-check', [StripePaymentController::class, 'mailCheck'])->name('stripe.mailcheck');

Route::get('/checkout2', [PaymentController::class, 'checkout']);
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);
//end setup apple pay



Route::get('/klarna/payment-session', [KlarnaPaymentController::class, 'createPaymentSession']);


Route::get('/stripe-payment', [StripePaymentController::class, 'stripePayment'])->name('stripe.payment');
Route::post('/create-payment-link', [StripePaymentController::class, 'createPaymentLink'])->name('stripe.create.payment');
Route::get('/payment-success', [StripePaymentController::class, 'success'])->name('stripe.success');
Route::get('/payment-cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
Route::post('/stripe-webhook', [StripePaymentController::class, 'handleWebhook']);
Route::post('/create-payment-link-shop', [StripePaymentController::class, 'createPaymentLinkShop'])->name('stripe.create.paymentshop');
Route::get('/payment-success-shop', [StripePaymentController::class, 'successshop'])->name('payment-success-shop');

Route::post('/stripe/apple-pay', [PaymentController::class, 'applePay'])->name('stripe.apple.pay');


Route::get('/stripecheckout', [StripeController::class, 'stripecheckout'])->name('stripecheckout');
Route::post('/process-payment', [StripeController::class, 'processPayment'])->name('process.payment');
Route::post('/booking-process-payment', [StripeController::class, 'bookingProcessPayment'])->name('booking.process.payment');


Route::post('/klarnaIntentCreate', [KlarnaController::class, 'klarnaIntentCreate'])->name('klarnaIntentCreate');
Route::post('/klarna-checkoutweb', [KlarnaController::class, 'initiatePaymentweb'])->name('klarna.checkoutweb');
Route::post('/klarna/authorizeweb', [KlarnaController::class, 'authorizePaymentweb'])->name('klarna.authorizeweb');
Route::post('/klarna/create-order-web', [KlarnaController::class, 'createOrderWeb'])->name('klarna.create-order-web');

Route::post('/klarna-checkout', [KlarnaController::class, 'initiatePayment'])->name('klarna.checkout');
Route::post('/klarna/authorize', [KlarnaController::class, 'authorizePayment'])->name('klarna.authorize');
Route::post('/klarna/create-order', [KlarnaController::class, 'createOrder'])->name('klarna.create-order');
Route::post('/klarna/payment-success', [KlarnaController::class, 'success'])->name('klarna.payment-success');
/*Route::get('/order-success', function() {
    return "Your order was successful!";
});*/



Route::get('/klarna/test-auth', function (\App\Services\KlarnaService $klarnaService) {
    try {
        $result = $klarnaService->testAuth();
        return response()->json(['success' => true, 'data' => $result]);
    } catch (\RuntimeException $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
});


//Route::get('/checkout/create', [CheckoutController::class, 'createOrder']);  

Route::get('/index.php', function () {
    return redirect('/');
});

Route::get('fraxel-laser-treatment/{any?}', function ($any = null) {
    //return $any;
    return redirect('/');
})->where('any', '.*');

Route::get('wp-content/{any?}', function ($any = null) {
    return redirect('/');
})->where('any', '.*');

Route::get('about-dr-rolla-abdelwahed/{any?}', function () {
    return redirect('/dr-rolla-abdelwahed', 301);
})->where('any', '.*');


Route::get('anti-wrinkles-injections/{any?}', function () {
    return redirect('/anti-wrinkles-injections', 301);
})->where('any', '.*');

Route::get('dermaroller-treatment/{any?}', function () {
    return redirect('/dermapen-microneedling', 301);
})->where('any', '.*');

Route::get('laser-hair-removal-for-men/{any?}', function () {
    return redirect('/laser-hair-removal-for-men', 301);
})->where('any', '.*');

Route::get('laser-hair-removal-for-women/{any?}', function () {
    return redirect('/laser-hair-removal-for-women', 301);
})->where('any', '.*');

Route::get('lips-fillers-treatment-in-london/{any?}', function () {
    return redirect('/lips-fillers-treatment-in-london', 301);
})->where('any', '.*');

Route::get('non-surgical-face-lift/{any?}', function () {
    return redirect('/non-surgical-face-lift', 301);
})->where('any', '.*');

Route::get('2023/{any?}', function () {
    return redirect('/', 301);
})->where('any', '.*');

Route::get('5d-facial-fotona/{any?}', function () {
    return redirect('/fotona-laser-treatment', 301);
})->where('any', '.*');



Route::get('login', [App\Http\Controllers\Frontend\LoginController::class, 'login'])->name('login');
Route::get('otp', [App\Http\Controllers\Frontend\LoginController::class, 'otp'])->name('otp');
Route::post('verify-otp', [App\Http\Controllers\Frontend\LoginController::class, 'verify_otp']);
Route::post('login', [App\Http\Controllers\Frontend\LoginController::class, 'login']);
Route::get('logout', [App\Http\Controllers\Frontend\LoginController::class, 'logout']);

Route::get('/', [App\Http\Controllers\Frontend\IndexController::class, 'index'])->name('/');


Route::get('sendManuallMail', [App\Http\Controllers\Frontend\IndexController::class, 'sendManuallMail'])->name('sendManuallMail');
Route::get('sendTestSms', [App\Http\Controllers\Frontend\IndexController::class, 'sendTestSms'])->name('sendTestSms');

//Route::get('services/{catid?}/{id?}', [App\Http\Controllers\Frontend\IndexController::class, 'services'])->name('services');
Route::get('/404', [App\Http\Controllers\Frontend\IndexController::class, 'pagenotfound'])->name('404');
Route::get('addon', [App\Http\Controllers\Frontend\IndexController::class, 'addon'])->name('addon');
Route::get('professional-time', [App\Http\Controllers\Frontend\IndexController::class, 'professional_time'])->name('professional-time');
Route::get('checkout', [App\Http\Controllers\Frontend\IndexController::class, 'checkout'])->name('checkout');
Route::get('booking-success', [App\Http\Controllers\Frontend\IndexController::class, 'booking_success'])->name('booking-success');
Route::post('updatetimeslot', [App\Http\Controllers\Frontend\IndexController::class, 'updatetimeslot'])->name('updatetimeslot');
Route::get('order-success', [App\Http\Controllers\Frontend\IndexController::class, 'order_success'])->name('order-success');
Route::post('bookWithoutPayment', [App\Http\Controllers\Frontend\IndexController::class, 'bookWithoutPayment'])->name('bookWithoutPayment');
Route::get('timeSlot', [App\Http\Controllers\Frontend\IndexController::class, 'timeSlot'])->name('timeSlot');
Route::post('timeSlot', [App\Http\Controllers\Frontend\IndexController::class, 'timeSlot'])->name('timeSlot');
Route::post('saveSelectedData', [App\Http\Controllers\Frontend\IndexController::class, 'saveSelectedData'])->name('saveSelectedData');
Route::post('consultationFormSave', [App\Http\Controllers\Frontend\IndexController::class, 'consultationFormSave'])->name('consultationFormSave');
Route::post('subscribeSave', [App\Http\Controllers\Frontend\IndexController::class, 'subscribeSave'])->name('subscribeSave');
Route::post('searchResult', [App\Http\Controllers\Frontend\IndexController::class, 'searchResult'])->name('searchResult');
Route::post('changeLanguage', [App\Http\Controllers\Frontend\IndexController::class, 'changeLanguage'])->name('changeLanguage');
Route::post('hidePopup', [App\Http\Controllers\Frontend\IndexController::class, 'hidePopup'])->name('hidePopup');
Route::post('addRemoveService', [App\Http\Controllers\Frontend\IndexController::class, 'addRemoveService'])->name('addRemoveService');
Route::post('addRemoveProduct', [App\Http\Controllers\Frontend\IndexController::class, 'addRemoveProduct'])->name('addRemoveProduct');
Route::post('update-cart', [App\Http\Controllers\Frontend\IndexController::class, 'update_cart'])->name('update-cart');
Route::get('web-checkout', [App\Http\Controllers\Frontend\IndexController::class, 'web_checkout'])->name('web-checkout');
Route::get('contact-us', [App\Http\Controllers\Frontend\IndexController::class, 'contact_us'])->name('contact-us');
//Route::get('contact', [App\Http\Controllers\Frontend\IndexController::class, 'contact'])->name('contact');
Route::get('book-free-consultation', [App\Http\Controllers\Frontend\IndexController::class, 'contact'])->name('book-free-consultation');
Route::get('referral', [App\Http\Controllers\Frontend\IndexController::class, 'referral'])->name('referral');
Route::get('about', [App\Http\Controllers\Frontend\IndexController::class, 'about'])->name('about');
Route::get('faq', [App\Http\Controllers\Frontend\IndexController::class, 'faq'])->name('faq');
Route::get('reviews', [App\Http\Controllers\Frontend\IndexController::class, 'reviews'])->name('reviews');
Route::get('finance-options', [App\Http\Controllers\Frontend\IndexController::class, 'finance_options'])->name('finance-options');
Route::get('locations', [App\Http\Controllers\Frontend\IndexController::class, 'locations'])->name('locations');
Route::get('locations/{slug}', [App\Http\Controllers\Frontend\IndexController::class, 'locations_details'])->name('locations-details');
Route::get('pricing', [App\Http\Controllers\Frontend\IndexController::class, 'pricing'])->name('pricing');
Route::get('pricing/{slug}', [App\Http\Controllers\Frontend\IndexController::class, 'pricing_detail'])->name('pricing-detail');
Route::get('refund-policy', [App\Http\Controllers\Frontend\IndexController::class, 'refund_policy'])->name('refund-policy');
Route::get('terms-conditions', [App\Http\Controllers\Frontend\IndexController::class, 'terms_conditions'])->name('terms-conditions');
Route::get('privacy-policy', [App\Http\Controllers\Frontend\IndexController::class, 'privacy_policy'])->name('privacy-policy');
Route::get('blog', [App\Http\Controllers\Frontend\IndexController::class, 'blog'])->name('blog');
//Route::get('blog-details/{id?}', [App\Http\Controllers\Frontend\IndexController::class, 'blog_details'])->name('blog-details');
Route::get('team', [App\Http\Controllers\Frontend\IndexController::class, 'team'])->name('team');
Route::get('team-details', [App\Http\Controllers\Frontend\IndexController::class, 'team_details'])->name('team-details');
Route::get('shop-details/{id?}', [App\Http\Controllers\Frontend\IndexController::class, 'shop_details'])->name('shop-details');
//Route::get('allservice/{id?}', [App\Http\Controllers\Frontend\IndexController::class, 'allservice'])->name('allservice');
Route::get('allcondition', [App\Http\Controllers\Frontend\IndexController::class, 'allcondition'])->name('allcondition');
Route::post('homesearchservice', [App\Http\Controllers\Frontend\IndexController::class, 'homesearchservice'])->name('homesearchservice');
Route::match(['get', 'post'], 'homesearchbox', [App\Http\Controllers\Frontend\IndexController::class, 'homesearchbox'])->name('homesearchbox');
Route::get('services', [App\Http\Controllers\Frontend\IndexController::class, 'allservices'])->name('services');
Route::get('offer', [App\Http\Controllers\Frontend\IndexController::class, 'offer'])->name('offer');
Route::get('shop', [App\Http\Controllers\Frontend\IndexController::class, 'shop'])->name('shop');
Route::get('cart', [App\Http\Controllers\Frontend\IndexController::class, 'cart'])->name('cart');
Route::post('web-checkout-process', [App\Http\Controllers\Frontend\IndexController::class, 'web_checkout_process'])->name('web-checkout-process');

Route::post('add-to-cart', [App\Http\Controllers\Frontend\IndexController::class, 'addToCart'])
    ->name('add.to.cart');
Route::get('get-cart', [App\Http\Controllers\Frontend\IndexController::class, 'getCart'])
    ->name('get.cart');
Route::post('cart/update-qty', [App\Http\Controllers\Frontend\IndexController::class, 'updateQty']);
Route::post('cart/remove', [App\Http\Controllers\Frontend\IndexController::class, 'removeItem']);

Route::middleware('auth:customer')->group(function () {
    Route::get('profile', [App\Http\Controllers\Frontend\ProfileController::class, 'profile'])->name('profile');
    Route::get('complete-your-account', [App\Http\Controllers\Frontend\ProfileController::class, 'complete_your_account'])->name('complete-your-account');
    Route::get('my-account', [App\Http\Controllers\Frontend\ProfileController::class, 'my_account'])->name('my-account');
    Route::get('booking', [App\Http\Controllers\Frontend\ProfileController::class, 'booking'])->name('booking');
    Route::get('course', [App\Http\Controllers\Frontend\ProfileController::class, 'course'])->name('course');
    Route::get('order', [App\Http\Controllers\Frontend\ProfileController::class, 'order'])->name('order');
    Route::post('updateProfile', [App\Http\Controllers\Frontend\ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::post('updateAddress', [App\Http\Controllers\Frontend\ProfileController::class, 'updateAddress'])->name('updateAddress');
});


Route::get('/sendPushNotification', [App\Http\Controllers\PushNotificationController::class, 'sendPushNotification'])->name('/sendPushNotification'); 




Route::get('share-project/{id}', [App\Http\Controllers\Admin\Master\SocietyControllerInAdmin::class, 'share_project'])->name('share_project');

Route::match(['get', 'post'], '/admin', [App\Http\Controllers\Admin\LoginControllerInAdmin::class, 'submitlogin'])->name('admin.login');
Route::match(['get', 'post'], 'forgot-password', [App\Http\Controllers\Admin\LoginControllerInAdmin::class, 'forgotpassword'])->name('forgot-password');

Route::get('createMoveinPayment', [App\Http\Controllers\Admin\Cron\CronControllerInAdmin::class, 'createMoveinPayment'])->name('createMoveinPayment');

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'prevent-back-history'], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\HomeControllerInAdmin::class, 'admin_dashboard'])->name('dashboard');
    Route::get('/logout', [App\Http\Controllers\Admin\LoginControllerInAdmin::class, 'logout'])->name('logout');
    
    // Medical History
    Route::resource('medicalhistory', App\Http\Controllers\Admin\MedicalHistory\MedicalHistoryControllerInAdmin::class);
    
    // Concern
    Route::resource('concern', App\Http\Controllers\Admin\Concern\ConcernControllerInAdmin::class);
    
    // Clinical Option
    Route::resource('clinicaloption', App\Http\Controllers\Admin\ClinicalOption\ClinicalOptionControllerInAdmin::class);
    
    
    // Treatment
    Route::resource('treatments', App\Http\Controllers\Admin\Treatment\TreatmentControllerInAdmin::class);
    
    // Property Category

    Route::get('propertycategory/{id?}', [App\Http\Controllers\Admin\Master\PropertyCategoryInAdmin::class, 'index'])->name('propertycategory');
    Route::post('savePropertyCategory', [App\Http\Controllers\Admin\Master\PropertyCategoryInAdmin::class, 'store'])->name('savePropertyCategory');
    Route::get('editPropertyCategory', [App\Http\Controllers\Admin\Master\PropertyCategoryInAdmin::class, 'editPropertyCategory'])->name('editPropertyCategory');
    Route::get('deletePropertyCategory/{id?}', [App\Http\Controllers\Admin\Master\PropertyCategoryInAdmin::class, 'deletePropertyCategory'])->name('deletePropertyCategory');

    // Property
    Route::resource('property', App\Http\Controllers\Admin\Property\PropertyControllerInAdmin::class);
    Route::post('deleteRoomById', [App\Http\Controllers\Admin\Property\PropertyControllerInAdmin::class, 'deleteRoomById'])->name('deleteRoomById');
    Route::post('propertyImportdata', [App\Http\Controllers\Admin\Property\PropertyControllerInAdmin::class, 'propertyImportdata'])->name('propertyImportdata');
    Route::get('property_list/{id}', [App\Http\Controllers\Admin\Property\PropertyControllerInAdmin::class, 'property_list'])->name('property_list');
    Route::get('property_status/{id}', [App\Http\Controllers\Admin\Property\PropertyControllerInAdmin::class, 'property_status'])->name('property_status');
    Route::get('property_offer_status/{id}', [App\Http\Controllers\Admin\Property\PropertyControllerInAdmin::class, 'property_offer_status'])->name('property_offer_status');

    // Addon
    Route::resource('addon', App\Http\Controllers\Admin\Addon\AddonControllerInAdmin::class);
    Route::get('addon_status/{id}', [App\Http\Controllers\Admin\Addon\AddonControllerInAdmin::class, 'addon_status'])->name('addon_status');
    
    // clinic
    Route::resource('clinic', App\Http\Controllers\Admin\Clinic\ClinicControllerInAdmin::class);
    Route::get('clinic_status/{id}', [App\Http\Controllers\Admin\Clinic\ClinicControllerInAdmin::class, 'clinic_status'])->name('clinic_status');
    
    // Redurl
    Route::resource('redurl', App\Http\Controllers\Admin\Redurl\RedurlControllerInAdmin::class);
    Route::get('redurl_status/{id}', [App\Http\Controllers\Admin\Clinic\ClinicControllerInAdmin::class, 'redurl_status'])->name('redurl_status');
    
    
    // KiBooking
    Route::resource('order', App\Http\Controllers\Admin\Order\OrderControllerInAdmin::class);
    Route::resource('kibooking', App\Http\Controllers\Admin\KiBooking\KiBookingControllerInAdmin::class);
    Route::get('kibooking_status/{id}', [App\Http\Controllers\Admin\KiBooking\KiBookingControllerInAdmin::class, 'kibooking_status'])->name('kibooking_status');
    Route::get('kibooking_web', [App\Http\Controllers\Admin\KiBooking\KiBookingControllerInAdmin::class, 'kibooking_web'])->name('kibooking_web');

    // Professional
    Route::resource('professional', App\Http\Controllers\Admin\Professional\ProfessionalControllerInAdmin::class);
    Route::get('professional_status/{id}', [App\Http\Controllers\Admin\Professional\ProfessionalControllerInAdmin::class, 'professional_status'])->name('professional_status');

    // Team
    Route::resource('team', App\Http\Controllers\Admin\Team\TeamControllerInAdmin::class);
    Route::get('team_status/{id}', [App\Http\Controllers\Admin\Team\TeamControllerInAdmin::class, 'team_status'])->name('team_status');

    // Property Ajax
    Route::post('getPropertySubCondByCond', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getPropertySubCondByCond'])->name('getPropertySubCondByCond');
    Route::post('getPropertySubCatByCat', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getPropertySubCatByCat'])->name('getPropertySubCatByCat');
    Route::post('getCategoryAttributes', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getCategoryAttributes'])->name('getCategoryAttributes');

    // Reviews
    Route::resource('reviews', App\Http\Controllers\Admin\Review\ReviewInAdmin::class);
    
    // Reviews
    Route::resource('consultation-form', App\Http\Controllers\Admin\Consultationform\ConsultationformInAdmin::class);
    Route::get('consultation-refer', [App\Http\Controllers\Admin\Consultationform\ConsultationformInAdmin::class, 'consultation_refer'])->name('consultation-refer');
    Route::get('subscribed-form', [App\Http\Controllers\Admin\Consultationform\ConsultationformInAdmin::class, 'subscribed_form'])->name('subscribed-form');

    //old routes need to delete
    Route::resource('areas', App\Http\Controllers\Admin\Master\DesignationControllerInAdmin::class);
    
    //mobile 
    Route::resource('brands', App\Http\Controllers\Admin\Mobile\MobileBrandInAdmin::class);
    Route::resource('models', App\Http\Controllers\Admin\Mobile\MobileModelInAdmin::class);
    Route::resource('variants', App\Http\Controllers\Admin\Mobile\MobileVariantInAdmin::class);
    Route::resource('colours', App\Http\Controllers\Admin\Mobile\MobileColourInAdmin::class);
    
    //Change MAster
    Route::resource('masters', App\Http\Controllers\Admin\Master\MasterControllerInAdmin::class);
    Route::get('master_status/{id}', [App\Http\Controllers\Admin\Master\MasterControllerInAdmin::class, 'master_status'])->name('master_status');

    //Change MAster Value
    Route::resource('mastervalues', App\Http\Controllers\Admin\Master\MasterValueControllerInAdmin::class);
    Route::get('master_values_status/{id}', [App\Http\Controllers\Admin\Master\MasterValueControllerInAdmin::class, 'master_values_status'])->name('master_values_status');
    //get Master Value detail
    Route::get('editmastervalue', [App\Http\Controllers\Admin\Master\MasterValueControllerInAdmin::class, 'editmastervalue'])->name('editmastervalue');
    
    Route::resource('banner', App\Http\Controllers\Admin\Banner\BannerControllerInAdmin::class);
    Route::get('banner_status/{id}', [App\Http\Controllers\Admin\Banner\BannerControllerInAdmin::class, 'banner_status'])->name('banner_status');
    
    Route::resource('faq', App\Http\Controllers\Admin\Faq\FaqControllerInAdmin::class);
    Route::get('faq_status/{id}', [App\Http\Controllers\Admin\Faq\FaqControllerInAdmin::class, 'faq_status'])->name('faq_status');
    Route::post('faq_sorting', [App\Http\Controllers\Admin\Faq\FaqControllerInAdmin::class, 'faq_sorting'])->name('faq_sorting');
    
    Route::resource('servicecatmain', App\Http\Controllers\Admin\Servicecat\ServicecatMainControllerInAdmin::class);
    Route::get('servicecatmain_status/{id}', [App\Http\Controllers\Admin\Servicecat\ServicecatMainControllerInAdmin::class, 'servicecatmain_status'])->name('servicecatmain_status');
    Route::post('servicecatmain_sorting', [App\Http\Controllers\Admin\Servicecat\ServicecatMainControllerInAdmin::class, 'servicecatmain_sorting'])->name('servicecatmain_sorting');
    
    Route::resource('servicecat', App\Http\Controllers\Admin\Servicecat\ServicecatControllerInAdmin::class);
    Route::get('servicecat_status/{id}', [App\Http\Controllers\Admin\Servicecat\ServicecatControllerInAdmin::class, 'servicecat_status'])->name('servicecat_status');
    Route::post('servicecat_sorting', [App\Http\Controllers\Admin\Servicecat\ServicecatControllerInAdmin::class, 'servicecat_sorting'])->name('servicecat_sorting');
    
    Route::resource('servicesubcat', App\Http\Controllers\Admin\Servicecat\ServicesubcatControllerInAdmin::class);
    Route::get('servicesubcat_status/{id}', [App\Http\Controllers\Admin\Servicecat\ServicesubcatControllerInAdmin::class, 'servicesubcat_status'])->name('servicesubcat_status');
    Route::post('servicesubcat_sorting', [App\Http\Controllers\Admin\Servicecat\ServicesubcatControllerInAdmin::class, 'servicesubcat_sorting'])->name('servicesubcat_sorting');
    
    Route::resource('skincondition', App\Http\Controllers\Admin\Skincondition\SkinconditionControllerInAdmin::class);
    Route::get('skincondition_status/{id}', [App\Http\Controllers\Admin\Skincondition\SkinconditionControllerInAdmin::class, 'skincondition_status'])->name('skincondition_status');
    Route::post('skincondition_sorting', [App\Http\Controllers\Admin\Skincondition\SkinconditionControllerInAdmin::class, 'skincondition_sorting'])->name('skincondition_sorting');
    
    Route::resource('skinsubcondition', App\Http\Controllers\Admin\Skincondition\SkinsubconditionControllerInAdmin::class);
    Route::get('skinsubcondition_status/{id}', [App\Http\Controllers\Admin\Skincondition\SkinsubconditionControllerInAdmin::class, 'skinsubcondition_status'])->name('skinsubcondition_status');
    Route::post('skinsubcondition_sorting', [App\Http\Controllers\Admin\Skincondition\SkinsubconditionControllerInAdmin::class, 'skinsubcondition_sorting'])->name('skinsubcondition_sorting');
    
    
    Route::resource('blog', App\Http\Controllers\Admin\Blog\BlogControllerInAdmin::class);
    Route::get('blog_status/{id}', [App\Http\Controllers\Admin\Blog\BlogControllerInAdmin::class, 'blog_status'])->name('blog_status');
    
    Route::resource('seo', App\Http\Controllers\Admin\Seo\SeoControllerInAdmin::class);
    Route::get('seo_status/{id}', [App\Http\Controllers\Admin\Seo\SeoControllerInAdmin::class, 'seo_status'])->name('seo_status');
    
    Route::resource('seller', App\Http\Controllers\Admin\Employee\SellerControllerInAdmin::class);
    Route::get('seller_desable/{id}', [App\Http\Controllers\Admin\Employee\SellerControllerInAdmin::class, 'seller_desable'])->name('seller_desable');
    Route::get('seller_kyc_approve/{id}', [App\Http\Controllers\Admin\Employee\SellerControllerInAdmin::class, 'seller_kyc_approve'])->name('seller_kyc_approve');
    Route::get('seller-kyc', [App\Http\Controllers\Admin\Employee\SellerControllerInAdmin::class, 'seller_kyc'])->name('seller-kyc');
    
    Route::resource('customer', App\Http\Controllers\Admin\Customer\CustomerControllerInAdmin::class);
    Route::get('customer_desable/{id}', [App\Http\Controllers\Admin\Customer\CustomerControllerInAdmin::class, 'customer_desable'])->name('customer_desable');
    Route::get('customer-address/{id}', [App\Http\Controllers\Admin\Customer\CustomerControllerInAdmin::class, 'customer_address'])->name('customer-address');
    Route::get('customer-emi/{id}', [App\Http\Controllers\Admin\Customer\CustomerControllerInAdmin::class, 'customer_emi'])->name('customer-emi');
    
    Route::resource('subadmin', App\Http\Controllers\Admin\Employee\SubadminControllerInAdmin::class);
    Route::get('subadmin_desable/{id}', [App\Http\Controllers\Admin\Employee\SubadminControllerInAdmin::class, 'subadmin_desable'])->name('subadmin_desable');
    
    Route::resource('employee', App\Http\Controllers\Admin\Employee\EmployeeControllerInAdmin::class);
    Route::get('getUserMap/{id}', [App\Http\Controllers\Admin\Employee\EmployeeControllerInAdmin::class, 'getUserMap'])->name('getUserMap');
    Route::get('employee_desable/{id}', [App\Http\Controllers\Admin\Employee\EmployeeControllerInAdmin::class, 'employee_desable'])->name('employee_desable');
    Route::get('getUserDocumentDetail', [App\Http\Controllers\Admin\Employee\EmployeeControllerInAdmin::class, 'getUserDocumentDetail'])->name('getUserDocumentDetail');
    
    Route::post('getModel', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getModel'])->name('getModel');
    Route::post('getVariant', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getVariant'])->name('getVariant');
    
    Route::post('getState', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getState'])->name('getState');
    Route::post('getcities', [App\Http\Controllers\Admin\Common\AjaxCommonControllerInAdmin::class, 'getcities'])->name('getcities');
    
    Route::get('customer-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'customer_list'])->name('customer-list');
    Route::get('emi-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'emi_list'])->name('emi-list');
    Route::get('active-emi', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'active_emi'])->name('active-emi');
    Route::get('pending-emi', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'pending_emi'])->name('pending-emi');
    Route::get('bounce-emi', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'bounce_emi'])->name('bounce-emi');
    
    Route::get('mobile-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'mobile_list'])->name('mobile-list');
    Route::get('mobile-model-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'mobile_model_list'])->name('mobile-model-list');
    Route::get('mobile-variant-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'mobile_variant_list'])->name('mobile-variant-list');
    Route::get('mobile-colour-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'mobile_colour_list'])->name('mobile-colour-list');
    Route::get('add-mobile', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_mobile'])->name('add-mobile');
    Route::get('add-mobile-model', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_mobile_model'])->name('add-mobile-model');
    Route::get('add-mobile-variant', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_mobile_variant'])->name('add-mobile-variant');
    Route::get('add-mobile-colour', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_mobile_colour'])->name('add-mobile-colour');
    Route::get('seller-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'seller_list'])->name('seller-list');
    Route::get('seller-kyc-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'seller_kyc_list'])->name('seller-kyc-list');
    Route::get('add-seller', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_seller'])->name('add-seller');
    Route::get('customer-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'customer_list'])->name('customer-list');
    Route::get('add-customer', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_customer'])->name('add-customer');
    Route::get('mobile-brand-list', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'mobile_brand_list'])->name('mobile-brand-list');
    Route::get('add-mobile-brand', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'add_mobile_brand'])->name('add-mobile-brand');
    Route::get('createmobilebrand', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'createmobilebrand'])->name('createmobilebrand');
    Route::get('createmobilemodal', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'createmobilemodal'])->name('createmobilemodal');
    Route::get('createmobilevariant', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'createmobilevariant'])->name('createmobilevariant');
    Route::get('createmobilecolor', [App\Http\Controllers\Admin\Pages\PagesControllerInAdmin::class, 'createmobilecolor'])->name('createmobilecolor');

});


Route::get('/{catid}', [App\Http\Controllers\Frontend\IndexController::class, 'allservice2'])->name('allservice2');



