<?php

namespace App\Http\Controllers\Taic;

use App\Events\MainSpeakerUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\Taic\SpeakerResource;
use App\Models\Taic\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class SpeakerController extends Controller
{
    protected $localImgPath;
    public function __construct()
    {
        $this->localImgPath = 'Uploads/Speakers';
        
    }
    public function index(){
        $isAdmin = Auth::user()->role->name === 'admin';
        $isAdmin ? $conferenceSpeakers = SpeakerResource::collection(Speaker::all()->sortByDesc('createdDate')) :
        $conferenceSpeakers = SpeakerResource::collection(Speaker::where('is_visible', 1)->get()->sortByDesc('createdDate'));

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
    public function create(Request $request) {
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
    public function singleSpeaker(string $id){
        $exists = Speaker::where('id', $id)->exists();
        if($exists){
            $data = new SpeakerResource(Speaker::findOrFail($id));
            return response()->json([
                'message' => 'Speaker data found',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'message' => 'Speaker data not found',
                'data' => null
            ]);
        }
       
    }
    public function getGoH(){
        $exists = Speaker::where('isMain', true)->exists();
        if($exists){
            $data = new SpeakerResource(Speaker::where('isMain', true)->first());
            return response()->json([
                'message' => 'Guest of Hounour Speaker data found',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'message' => 'Speaker data not found',
                'data' => null
            ]);
        }
       
    }
    public function switchVisibility(string $id){
        $exists = Speaker::where('id', $id)->exists();
        if($exists){
            $tgtSpeaker = Speaker::where('id',$id)->get()->first();
            $tgtSpeaker->is_visible = !$tgtSpeaker->is_visible;
            $tgtSpeaker->save();
            return response()->json([
                'message' => 'Visibility switched',
            ]);
        }else{
            return response()->json([
                'message' => 'Speaker data not found',
                'data' => null
            ]);
        }
       
    }
    public function makeSpeakerGuestOfHonour($conference_id,$uuid){
        $tgtdata = Speaker::where('id',$uuid)->get()->first();
        if($tgtdata){
            // Dispatching an Event
            $tgtdata->isMain = true;
            $tgtdata->save();
            event(new MainSpeakerUpdated($conference_id, $uuid));
            return response()->json([
                'message'=> $tgtdata->name.'  is Guest of Honour',
            ]);
        }
        return response()->json([
            'message'=> 'Conference Not Found',
            'code' => 300
        ]);
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
