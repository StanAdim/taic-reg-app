<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistrictResource;
use App\Http\Resources\RegionResource;
use App\Mail\CustomEmailVerification;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class GeneralController extends Controller
{
        //Get regions in tanzania
     
      //Get regions in tanzania
      public function getRegions(){
       $regions = RegionResource::collection(Region::all()) ;
       if ($regions) {
           return response()->json([
               'message' => 'Success Fetching Regions',
               'data' => $regions
           ],200);
       } else {
           return response()->json([
               'message' => 'No regions',
           ],404);
       }
      }
   
      public function getDistricts(Region $targetRegion){
           $district = DistrictResource::collection(District::where('region' , $targetRegion['region'])->get());
       if ($district) {
           return response()->json([
               'message' => 'Success Fetching Districts',
               'data' => $district
           ],200);
       } else {
           return response()->json([
               'message' => 'No district',
           ],404);
       }
   
      }
      public function sendVerificationEmail(){
        $user = Auth::user();
        $baseUrl = config('app.frontend_url');
        $url = $baseUrl . '/verify-user-account-' . $user->verificationKey;
        if($user){
            Mail::to($user->email)->send(new CustomEmailVerification($user,$url));
        }
        return response()->json([
            'message' => 'message sent',
        ]); 

      }
      public function verifyUserEmail($verificationKey){
        return $verificationKey;
        $user = Auth::user();
        $baseUrl = config('app.frontend_url');
        $url = $baseUrl . '/verify-user-account-' . $user->verificationKey;
        if($user){
            Mail::to($user->email)->send(new CustomEmailVerification($user, $url));
        }
        return response()->json([
            'message' => 'message sent',
        ]); 

      }
}
