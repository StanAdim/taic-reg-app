<?php

namespace App\Http\Controllers\Taic;

use App\Http\Controllers\Controller;
use App\Models\Taic\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimetableController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "day_id" => 'required',
            "startTime" => 'required',
            "endTime" => 'required',
            "status" => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newTimetable = $validator->validate();
        $newData = Timetable::create($newTimetable);
        return response()->json([
            'message'=> "New Timetable Created",
            'data' => $newData,
            'code'=> 200
        ],200);
    }

    public function getTimetableData(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
