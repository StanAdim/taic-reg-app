<?php

namespace App\Http\Controllers;

use App\Http\Resources\SystemUser;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
      public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "phoneNumber" => 'required',
            "user_id" => 'required',
            "professionalNumber" => '',
            "professionalStatus" => 'required',
            "institution" => '',
            "position" => '',
            "region_id" => 'required',
            "district_id" => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
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
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserInfo $userInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserInfo $userInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
