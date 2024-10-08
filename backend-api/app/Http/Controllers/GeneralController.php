<?php

namespace App\Http\Controllers;

use App\Http\Resources\DistrictResource;
use App\Http\Resources\RegionResource;
use App\Mail\CustomEmailVerification;
use App\Mail\PasswordResetMail;
use App\Models\Bill;
use App\Models\District;
use App\Models\Event\Subscription;
use App\Models\ExhibitionBooth;
use App\Models\ExhibitionRequest;
use App\Models\Nation;
use App\Models\Region;
use App\Models\Taic\Conference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{     
      //Get nations and regions
      public function getNationsRegions(){
       $nations = Nation::all() ;
       $regions = RegionResource::collection(Region::all()) ;
       if ($nations && $regions) {
           return response()->json([
               'message' => 'Success Fetching nations',
               'data' => [
                'nations'=> $nations,
                'regions'=> $regions,
               ]
           ],200);
       } else {
           return response()->json([
               'message' => 'No nations',
           ],404);
       }
      }

      public function countsAnalytics(){
        $authUser = Auth::user();
        $id = Auth::id();
        $users = User::all()->count();
        $conferences = Conference::all()->count();
        $booths = ExhibitionBooth::all()->count();
        $booth_request = ExhibitionRequest::all()->count();
        $activeConferences = Conference::where('status', 1)->count();
        $settle_payments = Bill::where('status', 1)->count();
        $booked_events = $authUser->subscriptions->count();
        $bills = $authUser->bills->count();
        $users = User::all()->count();
        $isAdmin = $authUser->role->name == "admin";
        // attendees
        $admin_stats =[];
        if($isAdmin) {
            $admin_stats = [
                'activeConferences' => $activeConferences,
                'bookedEvents' => $booked_events,
                'all_invoices' => Bill::all()->count(),
                'users' => $users,
                'conferences' => $conferences,
                'booths' => $booths,
                'boothRequest' => $booth_request,
                'settle_payments' => $settle_payments,
            ];
        }
        $other_stats = [
            'activeConferences' => $activeConferences,
            'bookedEvents' => $booked_events,
            'invoices' => $bills,
        ];
        return response()->json([
            'data'=>[
                'admin' => $admin_stats,
                'attendee' => $other_stats
            ]
        ]);
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
        if($user){
            $url = $baseUrl . '/verify-user-account-' . $user->verificationKey;
            Mail::to($user->email)->send(new CustomEmailVerification($user,$url));
            return response()->json([
                'message' => 'Activation Link sent to your Email',
            ],200); 
        }
      }
      public function sendPasswordReset(Request $request){
        $user = User::where('email',$request->email)->first();
        $baseUrl = config('app.frontend_url');
        if($user){
            $url = $baseUrl . '/account-reset-password-' . $user->verificationKey;
            Mail::to($user->email)->send(new PasswordResetMail($user,$url));
            return response()->json([
                'message' => 'Password reset Link sent to your Email',
            ],200); 
        }
        else{
            return response()->json([
                'message' => 'Account is not found: Register now',
            ],404);
        }

      }
      public function verifyUserEmail($verificationKey){
        $user = User::where('verificationKey',$verificationKey)->first();
        if ($user) {             // Update the email verification status
             DB::beginTransaction();
             $user->email_verified_at = Carbon::now();
             $user->save();
             DB::commit();

            return response()->json([
                'message' => 'Account verified successful',
            ],200);
        } else {
            return response()->json([
                'message' => 'Account is not found',
            ],404);
        }

      }
      public function previewDocument(Request $request)
      {
          $file_name = $request->name;
          if ($file_name == null) {
              abort(404);
          }
  
          if (!Storage::disk('local')->exists($file_name)) {
              abort(404);
          }
          $pdfPath = storage_path('app/'. $file_name);
          return response()->file($pdfPath);
      }
  
}
