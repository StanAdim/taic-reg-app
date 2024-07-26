<?php

namespace App\Http\Controllers\Taic;

use App\Events\ConferenceActivated;
use App\Http\Controllers\Controller;
use App\Http\Resources\Taic\ConferenceResource;
use App\Http\Resources\UpcomingEventResource;
use App\Models\Taic\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConferenceController extends Controller
{

    public function index()
    {
        //
        $conferences = ConferenceResource::collection(Conference::all()->sortBy('conferenceYear'));
        if($conferences){
            return response()->json([
                'message'=> "Conferences Fetch Success",
                'data' => $conferences,
                'code' => 200,
            ]);
        }
        return response()->json([
            'message'=> "No Conferences Found",
            'code' => 300,
        ]);
        
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "conferenceYear" => 'required|unique:conferences',
            "startDate" => 'required',
            "name" => 'required',
            "endDate" => 'required',
            "venue" => 'required|max:225|min:3',
            "theme" => 'required|min:3',
            "aboutConference" => 'required|min:3',
            "defaultFee" => 'required',
            "foreignerFee" => 'required',
            "guestFee" => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newConferenceData = $validator->validate();
        $newConference = Conference::create($newConferenceData);
        return response()->json([
            'message'=> "New Conference Created",
            'data' => $newConference,
            'code'=> 200
        ],200);
    }

    public function getConferenceData(string $uuid)
    {
        $tgtConference = ConferenceResource::collection(Conference::where('id',$uuid)->get())->first();
        if($tgtConference){
            return response()->json([
                'message'=> 'Conference Details: Found',
                'data' => $tgtConference,
                'code' => 200
            ]);
        }
        return response()->json([
            'message'=> 'Conference Not Found',
            'code' => 300
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "id" => 'required',
            "startDate" => '',
            "name" => '',
            "conferenceYear" => '',
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
        $targetUpdated = Conference::where('id', $data['id'])->update($data);
        if($targetUpdated){
            // $dataUpdated = Conference::where('id', $data['id'])->get()->first();
            return response()->json([
                'message'=> 'Application Data Updated',
                'code' => 200
             ]);
        }
        return response()->json([
            'message'=> 'Updated Failed',
            'code' => 300
        ]);
    }
    public function conferenceActiveate($uuid)
    {
        $tgtConference = Conference::where('id',$uuid)->get()->first();
        if($tgtConference){
            // Dispatching an Event
            $tgtConference->lock = true;
            $tgtConference->save();
            event(new ConferenceActivated($tgtConference));
            return response()->json([
                'message'=> $tgtConference->conferenceYear.' Conference is Active',
                'data' => $tgtConference,
                'code' => 200
            ]);
        }
        return response()->json([
            'message'=> 'Conference Not Found',
            'code' => 300
        ]);
    }

    public function getUpcomingEvents()
    {
        //
        $targetUpdated = UpcomingEventResource::collection(Conference::where('lock', true)->get());
        return response()->json([
            'message'=> 'Conference Not Found',
            'data' => $targetUpdated,
            'code' => 200
        ]);
    }
}
