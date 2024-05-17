<?php

namespace App\Http\Controllers\Taic;

use App\Http\Controllers\Controller;
use App\Http\Resources\Taic\SpeakerResource;
use App\Models\Taic\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeakerController extends Controller
{
    public function index()
    {
        $conferenceSpeakers = SpeakerResource::collection(Speaker::all()->sortBy('created_at'));
        if($conferenceSpeakers){
            return response()->json([
                'message'=> "TAIC Speakers",
                'data' => $conferenceSpeakers,
                'code' => 200,
            ]);
        }
        return response()->json([
            'message'=> "No Speakers Found",
            'code' => 300,
        ]);
        
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => 'required|unique:speakers',
            "name" => 'required|min:3',
            "designation" => 'required',
            "institution" => 'required|max:225|min:3',
            "linkedinLink" => '',
            "twitterLink" => '',
            "conference_id" => 'required|min:3',
            "imgPath" => ''
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newSpeakerInfo = $validator->validate();
        $newSpeaker = Speaker::create($newSpeakerInfo);
        return response()->json([
            'message'=> "Conference Speaker Created",
            'data' => $newSpeaker,
            'code'=> 200
        ],200);
    }

    public function getConferenceData(string $id)
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
