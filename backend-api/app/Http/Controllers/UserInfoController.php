<?php

namespace App\Http\Controllers;

use App\Http\Resources\SystemUser;
use App\Http\Resources\UserResource;
use App\Models\Professional;
use App\Models\User;
use App\Models\UserInfo;
use Database\Seeders\ProfessionalSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
      public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "phoneNumber" => 'required|starts_with:255',
            "user_id" => 'required',
            "professionalStatus" => 'required',
            "professionalNumber" => 'required_if:professionalStatus,1',
            "institution" => '',
            "position" => '',
            "region_id" => 'required',
            "address" => 'required',
            "district_id" => '',
            "notificationConsent" => '',
            "nation" => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
        // return $newItem;
        if($newItem["professionalNumber"] && $newItem['professionalStatus']){

            $professional = Professional::where('RegNo', $newItem["professionalNumber"] );
            $exists = $professional ->exists();
            $professional = $professional -> first();
            if($exists && !$professional->isVerified){
                // update used Professiona number  
                $professional->isVerified = 1;
                $professional->save();
                $user  = User::where('id',$newItem['user_id'] )->get()->first();
                if($user){
                    $user->update(['hasInfo'=>1]);
                    $newData = UserInfo::create($newItem);
                    return response()->json([
                        'message'=> "User Info Created",
                        'data' => $newData,
                        'code'=> 200
                    ],200);
                }
            }
           else{
            return response()->json([
                'message'=> 'Wrong Professional Number',
            ],422);
           }
        }
        $user  = User::where('id',$newItem['user_id'] )->get()->first();
            if($user){
                $user->update(['hasInfo'=>1]);
                $newData = UserInfo::create($newItem);
                return response()->json([
                    'message'=> "User Info Created",
                    'data' => $newData,
                    'code'=> 200
                ],200);
            }
        
    }

    public function systemUsers()
    {
        //
        $users = SystemUser::collection(User::all());
        if($users){
            return response()->json([
                'message'=> "Application Users",
                'data' => $users,
                'code' => 200,
            ]);
        }
        return response()->json([
            'message'=> "No users Found",
            'code' => 300,
        ]);
        
    }
    public function retrieveSystemUserDetails($user_key){
        $user = new SystemUser(User::where('verificationKey',$user_key)->first());
         
        if ($user) { 
            $subscriptions = $user->subscriptions ;
            $bills = $user->bills ;
            $data = array_merge(['user'=> $user], ['subscriptions'=>$subscriptions, 'bills'=> $bills]);          // Update the email verification status
            return response()->json([
                'message' => 'User Details retrieved',
                'data' => $data 
            ],200);
        } else {
            return response()->json([
                'message' => 'Account is not found',
            ],404);
        }

      }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserInfo $infoId)
    {
        $validator = Validator::make($request->all());
        $info = $validator->validate();
        UserInfo::where('id', $infoId)->first();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
