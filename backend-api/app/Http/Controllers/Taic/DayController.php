<?php

namespace App\Http\Controllers\Taic;

use App\Http\Controllers\Controller;
use App\Http\Resources\Taic\DayResource;
use App\Models\Taic\Activity;
use App\Models\Taic\Day;
use App\Models\Taic\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DayController extends Controller
{
    public function schedules()
    {
        //
        $schedules = DayResource::collection(Day::all());
        $timetables = Timetable::all();
        $activities = Activity::all();
        if($schedules){
            return response()->json([
                'message'=> "TAIC Schedules",
                'data' => [
                    'days' => $schedules,
                    'timetable' => $timetables,
                    'activities' => $activities
                ],
                'code' => 200,
            ]);
        }
        return response()->json([
            'message'=> "No schedules Found",
            'code' => 300,
        ]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "conference_id" => 'required',
            "date" => 'required',
            "label" => 'required',
            "status" => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newConferenceDay = $validator->validate();
        $newData = Day::create($newConferenceDay);
        return response()->json([
            'message'=> "New Day Created",
            'data' => $newData,
            'code'=> 200
        ],200);
    }

    public function getConferenceDay(string $uuid)
    {
        $tgtConferenceDay = Day::where('id',$uuid)->get()->first();
        if($tgtConferenceDay){
            return response()->json([
                'message'=> 'Conference Day: Found',
                'data' => $tgtConferenceDay,
                'code' => 200
            ]);
        }
        return response()->json([
            'message'=> 'Conference Day Not Found',
            'code' => 300
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required',
            "startDate" => '',
            "endDate" => '',
            "venue" => '',
            "theme" => '',
            "aboutConference" => '',
            "defaultFee" => '',
            "foreignerFee" => '',
            "guestFee" => '',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $data = $validator->validate();
        $targetUpdated = Day::where('id', $data['id'])->update($data);
        if($targetUpdated){
            // $dataUpdated = Conference::where('id', $data['id'])->get()->first();
            return response()->json([
                'message'=> 'Day details Updated',
                'code' => 200
             ]);
        }
        return response()->json([
            'message'=> 'Updated Failed',
            'code' => 300
        ]);
    }
    public function conferenceDayActivate($uuid)
    {
        $tgtConferenceDay = Day::where('id',$uuid)->get()->first();
        if($tgtConferenceDay){
            // Dispatching an Event
            $tgtConferenceDay->lock = true;
            $tgtConferenceDay->save();
            // event(new ConferenceActivated($tgtConferenceDay));
            return response()->json([
                'message'=> $tgtConferenceDay->conferenceYear.' Conference is Active',
                'data' => $tgtConferenceDay,
                'code' => 200
            ]);
        }
        return response()->json([
            'message'=> 'Conference Day Not Found',
            'code' => 300
        ]);
    }

    public function destroy(string $id)
    {
        //
    }
}
