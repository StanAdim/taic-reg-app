<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Taic\ActivityController;
use App\Http\Controllers\Taic\ConferenceController;
use App\Http\Controllers\Taic\DayController;
use App\Http\Controllers\Taic\SiteController;
use App\Http\Controllers\Taic\SpeakerController;
use App\Http\Controllers\Taic\TimetableController;
use App\Http\Controllers\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/auth/user', [AuthenticatedSessionController::class,'authUserCall']);
Route::get('/test',function(){return 'API: - Test route Active';});
Route::get('/mail',function(){return view('mail.verification.verifyUserEmail');});
 // ================ LOCATION API ============================================
 Route::get('/get-country-regions',[GeneralController::class, 'getRegions']);
 Route::get('/send-verification-email',[GeneralController::class, 'sendVerificationEmail']);
 Route::get('/verify-user-email-{verificationKey}',[GeneralController::class, 'verifyUserEmail']);
 Route::get('/site-data', [SiteController::class , 'fetchSiteData']);
 Route::get('/get-districts/{targetRegion}',[GeneralController::class, 'getDistricts']);
 Route::middleware(['auth:sanctum'])->group(function(){
     Route::post('/user-info-create',[UserInfoController::class, 'create']);
     Route::get('/application-users',[UserInfoController::class, 'systemUsers']);
     Route::get('/subscribe-event/{eventId}/{eventFee}', [SubscriptionController::class,'subscribeToEvent']);
     Route::get('/user/subscribed-events', [SubscriptionController::class,'subscribedEvents']);
     Route::get('/user/subscribed-event-bills', [BillController::class,'userBill']);
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

});