<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UserInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/auth/user', function (Request $request) {
    return Auth::user();
});
Route::get('/test',function(){return 'API: - Test route Active';});
 // ================ LOCATION API ============================================
 Route::get('/get-country-regions',[GeneralController::class, 'getRegions']);
 Route::get('/get-districts/{targetRegion}',[GeneralController::class, 'getDistricts']);
 Route::post('/user-info-create',[UserInfoController::class, 'create']);
