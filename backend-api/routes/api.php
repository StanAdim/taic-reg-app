<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DocumentMaterialController;
use App\Http\Controllers\ExhibitionRequestController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Taic\ActivityController;
use App\Http\Controllers\Taic\ConferenceController;
use App\Http\Controllers\Taic\DayController;
use App\Http\Controllers\Taic\SiteController;
use App\Http\Controllers\Taic\SpeakerController;
use App\Http\Controllers\Taic\TimetableController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\ExhibitionBoothController;
use Illuminate\Support\Facades\Route;

Route::post('bill/receive-controll', [BillController::class,'receiveControlNumber']);
Route::post('bill/receive-payment', [BillController::class,'handlePayment']);
Route::post('bill/reconciliation-response', [BillController::class,'handleGepgReconcileRes']);
Route::middleware(['auth:sanctum'])->get('/auth/user', [AuthenticatedSessionController::class,'authUserCall']);
Route::get('/test',function(){  $eventName = 'Taic Event'; return view('invoices.subscriptionInvoice',compact(['eventName']));});
Route::get('/mail-{verificationKey}', [GeneralController::class, 'verifyUserEmail']);
 // ================ public routes ============================================
 Route::get('/get-locations',[GeneralController::class, 'getNationsRegions']);
 Route::get('/get-country-regions',[GeneralController::class, 'getRegions']);
 Route::get('/send-verification-email',[GeneralController::class, 'sendVerificationEmail']);
 Route::post('/send-password-reset-link',[GeneralController::class, 'sendPasswordReset']);
 Route::get('/verify-user-email-{verificationKey}',[GeneralController::class, 'verifyUserEmail']);
 Route::get('/site-data', [SiteController::class , 'fetchSiteData']);
 Route::get('/get-districts/{targetRegion}',[GeneralController::class, 'getDistricts']);
 Route::post('/reset-password', [RegisteredUserController::class, 'passwordResetting'])
 ->middleware('guest')
 ->name('password.reseting');

 Route::post('/call/professional-details', [ProfessionalController::class,'getProfessionalDetails']);

 //public events
 Route::get('/get-upcoming-events',[ConferenceController::class, 'getUpcomingEvents']);
 //--- Auth routes
 Route::middleware(['auth:sanctum'])->group(function(){
     Route::post('/user-info-create',[UserInfoController::class, 'create']);
     Route::post('/user/information-update',[UserInfoController::class, 'update']);
     Route::get('/application-users',[UserInfoController::class, 'systemUsers']);
     Route::get('/system-user-{user_key}',[UserInfoController::class, 'retrieveSystemUserDetails']);

     Route::get('/subscribe-event/{eventId}', [SubscriptionController::class,'subscribeToEvent']);
     Route::get('/user/subscribed-events', [SubscriptionController::class,'subscribedEvents']);
     Route::get('/user/subscribed-event-bills', [BillController::class,'userBill']);

     // Conference Document Material
     Route::post('/upload-document', [DocumentMaterialController::class, 'upload']);

    //Conferences ------------

    Route::get('/taic-conferences', [ConferenceController::class,'index']);
    Route::get('/conference-data/{uuid}', [ConferenceController::class,'getConferenceData']);
    Route::get('/conference/activate/{uuid}', [ConferenceController::class,'conferenceActiveate']);
    Route::post('/create-conference-data', [ConferenceController::class,'create']);
    Route::post('/update-conference-data', [ConferenceController::class,'update']);
    // Speakers --------------
    Route::get('/conference-speakers', [SpeakerController::class,'index']);
    Route::post('/create-conference-speaker', [SpeakerController::class,'create']);
    Route::post('/update-conference-speaker', [SpeakerController::class,'update']);
    Route::get('/honorable-speaker/activate/{uuid}', [SpeakerController::class,'activateHonourable']);
    //Conference Schedules ---------
    Route::get('/conference-schedules', [DayController::class,'schedules']);
    Route::post('/create-conference-day', [DayController::class,'create']);
    Route::post('/create-conference-timetable', [TimetableController::class,'create']);
    Route::post('/update-conference-day', [DayController::class,'update']);
    Route::post('/update-conference-timetable', [TimetableController::class,'update']);
    Route::post('/create-conference-activity', [ActivityController::class,'create']);
    // Route::get('/honorable-speaker/activate/{uuid}', [SpeakerController::class,'activateHonourable']);

    Route::get('/event-bills', [BillController::class,'index']);
    
    Route::get('/bill/reconciliation/{bill_id', [BillController::class,'handleReconciliationRequest']);
    Route::get('/bill/cancellation/{bill_id}', [BillController::class,'handleCancellationRequest']);


     Route::apiResource('/booth-request', ExhibitionRequestController::class);
     Route::apiResource('/exhibition-booth', ExhibitionBoothController::class);

});

///Test route