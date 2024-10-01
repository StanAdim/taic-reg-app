<?php

namespace App\Http\Controllers\Taic;

use App\Http\Controllers\Controller;
use App\Http\Resources\Taic\SpeakerResource;
use App\Models\Taic\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class SpeakerController extends Controller
{
    protected $localImgPath;
    public function __construct()
    {
        $this->localImgPath = 'Uploads/Speakers';
        
    }
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
            "brief_bio" => '',
            "agenda_title" => '',
            "agenda_desc" => '',
            "conference_id" => 'required|min:3',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newSpeakerInfo = $validator->validate();

          // Handling files 
          $imageFile = $request->file('imgPath');
          $imageOwnerName = $request->name;
          //Move Uploaded File
          if ($imageFile) {
              $imageFileName = $imageOwnerName. '-'.Str::random(8) . '.' . $imageFile->getClientOriginalExtension();
              $imageFile->move($this->localImgPath, $imageFileName);
          } else {
              $imageFileName = 'noFileUpload.pdf';
          }
          $fileName = [
            'imageFileName' => $imageFileName,
          ];
        $newSpeakerInfo = array_merge($newSpeakerInfo,$fileName);
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
