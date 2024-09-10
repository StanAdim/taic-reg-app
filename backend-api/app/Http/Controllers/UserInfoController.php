<?php

namespace App\Http\Controllers;

use App\Http\Resources\SystemUser;
use App\Models\Professional;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
      public function create(Request $request){
        $validator = Validator::make($request->all(), [
            "phoneNumber" => 'required|starts_with:+',
            "user_id" => 'required',
            "professionalStatus" => 'required',
            "professionalNumber" => 'required_if:professionalStatus,1',
            "institution" => '',
            "position" => '',
            "region_id" => '',
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
                    'message'=> "Information saved!",
                    'data' => $newData,
                    'code'=> 200
                ],200);
            }
        
    }

    public function systemUsers(Request $request){
    // Fetch the search term from the request (optional)
    $search = $request->input('search');
    $perPage = $request->input('per_page', 12); // Default items per page is 12

    // Build the query for fetching users
    $query = User::query()->orderBy('created_at', 'desc');
    // Apply search if there is a search term
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('firstName', 'like', "%{$search}%")
              ->orWhere('lastName', 'like', "%{$search}%")
              ->orWhere('middleName', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
              // Add other fields for search if needed
        });
    }

    // Paginate the results
    $users = $query->paginate($perPage);
    if ($users->isNotEmpty()) {
        return response()->json([
            'message' => "Application Users",
            'data' => SystemUser::collection($users),
            'pagination' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'next_page_url' => $users->nextPageUrl(),
                'prev_page_url' => $users->previousPageUrl(),
            ],
            'code' => 200,
        ]);
    }

    return response()->json([
        'message' => "No users found",
        'code' => 300,
    ]);
}

    public function retrieveSystemUserDetails($user_key){
        $user = new SystemUser(User::where('verificationKey',$user_key)->first());
         if ($user) { 
            $subscriptions = $user->subscriptions ;
            $bills = $user->bills ;
            $data = array_merge(['user'=> $user] , 
            ['subscriptions'=>$subscriptions->count(), 'bills'=> $bills->count()]);          // Update the email verification status
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
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            "id" => 'required',
            "phoneNumber" => 'required|starts_with:+',
            "professionalStatus" => 'required',
            "professionalNumber" => 'required_if:professionalStatus,"1"',
            "institution" => '',
            "position" => '',
            "region_id" => '',
            "address" => '',
            "district_id" => '',
            "notificationConsent" => '',
            "nation" => '',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
        $existingInfo = UserInfo::where('id',$newItem['id']);

        // return $newItem;
        if($newItem["professionalNumber"] && $newItem['professionalStatus']){
            $professional = Professional::where('RegNo', $newItem["professionalNumber"] );
            $exists = $professional ->exists();
            $professional = $professional -> first();
            if($exists && !$professional->isVerified){
                // update used Professiona number  
                $professional->isVerified = 1;
                $professional->save();
                //update data
                $existingInfo -> update($newItem);
                return response()->json([
                    'message'=> "Information updated",
                    'data' => $existingInfo,
                    'code'=> 200
                ],200);
            }else{
                $existingInfo -> update($newItem);
                return response()->json([
                    'message'=> 'Professional Number already verified',
                ],200);
            }
        }
        else{
        $existingInfo -> update($newItem);
        return response()->json([
            'message'=> 'Wrong Professional Number',
        ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
