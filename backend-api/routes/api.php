<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\DocumentMaterialController;
use App\Http\Controllers\EventBadgeController;
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
use App\Http\Controllers\FileExportController;
use App\Http\Controllers\InvitationRequestController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\SupportRequestController;
use App\Http\Controllers\SupportResponseController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::post('bill/receive-controll', [BillController::class,'receiveControlNumber']);
Route::post('bill/receive-payment', [BillController::class,'handlePayment']);
Route::post('bill/reconciliation-response', [BillController::class,'handleGepgReconcileRes']);

Route::middleware(['auth:sanctum'])->get('/auth/user', [AuthenticatedSessionController::class,'authUserCall']);
Route::get('/test',function(){  $eventName = 'Taic Event'; return view('pdf.receipt',compact(['eventName']));});
Route::get('/mail-{verificationKey}', [GeneralController::class, 'verifyUserEmail']);
 // ================ public routes ============================================
 Route::get('/get-locations',[GeneralController::class, 'getNationsRegions']);
 Route::get('/get-country-regions',[GeneralController::class, 'getRegions']);
 Route::get('/send-verification-email',[GeneralController::class, 'sendVerificationEmail']);
 Route::post('/send-password-reset-link',[GeneralController::class, 'sendPasswordReset']);
 Route::get('/verify-user-email-{verificationKey}',[GeneralController::class, 'verifyUserEmail']);
 Route::get('/site-data', [SiteController::class , 'fetchSiteData']);
 Route::get('/get-districts/{targetRegion}',[GeneralController::class, 'getDistricts']);
 Route::post('/reset-password', [RegisteredUserController::class, 'passwordResetting'])->middleware('guest')->name('password.reseting');

 Route::post('/call/professional-details', [ProfessionalController::class,'getProfessionalDetails']);
 Route::get('/events-document/{name}', [DocumentMaterialController::class, 'getDocumentByName']);


 //public events
 Route::get('/get-upcoming-events',[ConferenceController::class, 'getUpcomingEvents']);
 Route::get('/site-conference-speakers', [SpeakerController::class,'taicSite']);
 Route::get('/site-sponsorship',[SponsorshipController::class,'taicSiteSponsorships']);

 //--- Auth routes
 Route::middleware(['auth:sanctum'])->group(function(){
     Route::post('/user-info-create',[UserInfoController::class, 'create']);
     Route::get('/analytics-data',[GeneralController::class, 'countsAnalytics']);
     Route::post('/user/information-update',[UserInfoController::class, 'update']);
     Route::post('/user/information-update',[UserInfoController::class, 'update']);
     Route::get('/application-users',[UserInfoController::class, 'systemUsers']);
     Route::get('/system-user-{user_key}',[UserInfoController::class, 'retrieveSystemUserDetails']);
     Route::post('/admin-update-user-data/{userKey}',[RegisteredUserController::class, 'adminUpdateUser']);
     Route::get('/admin-update-user-role/{userKey}-{roleId}',[RegisteredUserController::class, 'adminUpdateRole']);

     Route::get('/professional-list',[ProfessionalController::class, 'professionalList']);
     Route::post('/store-professional',[ProfessionalController::class, 'store']);
     Route::post('/import-professionals-excel',[ProfessionalController::class, 'importExel']);

     Route::get('/subscribe-event/{eventId}', [SubscriptionController::class,'subscribeToEvent']);
     Route::post('/unsubscribe-user-from-event', [SubscriptionController::class,'unsubscribeUserFromEvent']);
     Route::get('/user/subscribed-events', [SubscriptionController::class,'subscribedEvents']);
     Route::get('/user/subscribed-event-bills', [BillController::class,'userBill']);

     // Conference Document Material
     Route::post('/upload-document', [DocumentMaterialController::class, 'docUpload']);
     Route::get('/events-documents', [DocumentMaterialController::class, 'index']);
     Route::delete('/events-document-delete-{id}', [DocumentMaterialController::class, 'destroy']);
     Route::put('/events-document-update-{id}', [DocumentMaterialController::class, 'updateStatus']);
     Route::get('/preview-document', [GeneralController::class, 'previewDocument']);

    //Conferences ------------
    Route::get('/taic-conferences', [ConferenceController::class,'index']);
    Route::get('/conference-data/{uuid}', [ConferenceController::class,'getConferenceData']);
    Route::get('/conference/activate/{uuid}', [ConferenceController::class,'conferenceActiveate']);
    Route::get('/conference/change-status/{uuid}', [ConferenceController::class,'conferenceDeactivate']);
    Route::post('/create-conference-data', [ConferenceController::class,'create']);
    Route::post('/update-conference-data', [ConferenceController::class,'update']);
    // Speakers --------------
    Route::get('/conference-speakers', [SpeakerController::class,'index']);
    Route::post('/create-conference-speaker', [SpeakerController::class,'create']);
    Route::post('/update-conference-speaker', [SpeakerController::class,'update']);
    Route::get('/honorable-speaker/activate/{uuid}', [SpeakerController::class,'activateHonourable']);
    Route::get('/conference-speaker/{uuid}', [SpeakerController::class,'singleSpeaker']);
    Route::get('/conference-goh-speaker', [SpeakerController::class,'getGoH']);
    Route::get('/conference-speaker/switch-visibility/{uuid}', [SpeakerController::class,'switchVisibility']);
    Route::get('/conference-speaker/guest-of-honour/{conference_id}/{uuid}', [SpeakerController::class,'makeSpeakerGuestOfHonour']);

    //Conference Schedules ---------
    Route::get('/conference-schedules', [DayController::class,'schedules']);
    Route::post('/create-conference-day', [DayController::class,'create']);
    Route::post('/create-conference-timetable', [TimetableController::class,'create']);
    Route::post('/update-conference-day', [DayController::class,'update']);
    Route::post('/update-conference-timetable', [TimetableController::class,'update']);
    Route::post('/create-conference-activity', [ActivityController::class,'create']);
    // Route::get('/honorable-speaker/activate/{uuid}', [SpeakerController::class,'activateHonourable']);
    Route::get('/event-bills', [BillController::class,'index']);
    Route::get('/event-bills-settled', [BillController::class,'settledBills']);
    
    Route::post('/bill/reconciliation', [BillController::class,'handleReconciliationRequest']);
    Route::get('/bill/cancellation/{bill_id}', [BillController::class,'handleCancellationRequest']);
    Route::get('/generate-invoice/{type}/{user_bill}', [BillController::class, 'generateInvoice']);
    Route::get('/generate-certificate/{user}/{conference}', [FileExportController::class, 'exportParticipationCertificate']);
    
    Route::apiResource('/booth-request', ExhibitionRequestController::class);
    Route::apiResource('/exhibition-booth', ExhibitionBoothController::class);
    Route::apiResource('/role', RoleController::class);
    Route::apiResource('/permission', PermissionController::class);
    Route::apiResource('/request-invitation-letter',InvitationRequestController::class);
    Route::get('/request-support-latest',[SupportRequestController::class,'latestUserRequest']);
    Route::apiResource('/request-support',SupportRequestController::class);
    Route::apiResource('/respond-support-request',SupportResponseController::class);
    Route::apiResource('/sponsorship', SponsorshipController::class);

    // Gateway routes
    Route::get('/gateway/registered-system', [PaymentGatewayController::class,'registeredSystem']);
    Route::post('/gateway/register-system', [PaymentGatewayController::class,'addNewSystem']);
    Route::post('/gateway/updated-system/{id}', [PaymentGatewayController::class,'updateSystem']);
    Route::get('/gateway/bills-requests', [PaymentGatewayController::class,'index']);

    // Excells and file exports
    Route::get('/export-report-users', [FileExportController::class, 'exportUsers']);
    Route::get('/export-report-bills', [FileExportController::class, 'exportBills']);
    Route::get('/export-report-payments', [FileExportController::class, 'exportPayments']);
    Route::get('/export-report-participants', [FileExportController::class, 'exportParticipants']);
    Route::get('/file-preview', [FileExportController::class, 'downloadFile']);
});
 // ================ Gaywey route routes ============================================
Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::post('/v1/gateway-bill-submission', [PaymentGatewayController::class, 'handleBillSubmission']);
});

Route::get('/certificate-participation', [FileExportController::class, 'exportParticipationCertificate']);
Route::get('/certificate-participation-1', [FileExportController::class, 'printCertificate']);

///Test route
Route::get('/send-test-email', function () {
    $details = [ 'title' => 'Test Email from EMS', 'body' => 'This is a test email sent EMS system.', ];
    Mail::to('stanjustine@gmail.com')->send(new \App\Mail\TestMail($details));
    return 'Test Email Sent!';
});
Route::get('/test', function() {
    return 'test is live';
});
Route::get('/test-card', [EventBadgeController::class, 'sendBadgeToParticipant']);

