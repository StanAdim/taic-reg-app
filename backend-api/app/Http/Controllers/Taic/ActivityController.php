<?php

namespace App\Http\Controllers\Taic;

use App\Http\Controllers\Controller;
use App\Models\Taic\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "hasMinActivity" => 'required',
            "minActivity" => '',
            "hasPanelist" => 'required',
            "panelist" => 'array',
            "moderator" => '',
            "timetable_id" => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newActivity = $validator->validate();
        $newData = Activity::create($newActivity);
        return response()->json([
            'message'=> "New Activity Created",
            'data' => $newData,
            'code'=> 200
        ],200);
    }
}
