<?php

namespace App\Http\Controllers;

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
        $newData = UserInfo::create($newItem);
        return response()->json([
            'message'=> "User Info Created",
            'data' => $newData,
            'code'=> 200
        ],200);
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserInfo $userInfo)
    {
        //
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
