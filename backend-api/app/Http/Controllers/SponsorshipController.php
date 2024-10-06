<?php

namespace App\Http\Controllers;

use App\Http\Resources\SiteSponsorshipResource;
use App\Http\Resources\SponsorshipResource;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SponsorshipController extends Controller
{
    protected $localImgPath;
    public function __construct()
    {
        $this->localImgPath = 'Uploads/Sponsors';
        
    }
    public function index(Request $request){
        // Fetch the search term from the request (optional)
        $category = $request->input('category');
        $data = [];
        switch ($category) {
            case '1':
                $data = Sponsorship::where('category', 'Sponsor')->get();
                break;
            case '2':
                $data = Sponsorship::where('category', 'Partner')->get();
                 break;
            case '3':
            $data = Sponsorship::where('category', 'Exhibitor')->get();
                break;
            default:
                $data = Sponsorship::all();
                break;
        }
        return SponsorshipResource::collection($data);
    }
    public function taicSiteSponsorships(){
        $sponsors = SiteSponsorshipResource::collection(Sponsorship::where('is_visible', 1)
        ->where('category', 'Sponsor')
        ->get()->sortByDesc('createdDate'));
        $partners = SiteSponsorshipResource::collection(Sponsorship::where('is_visible', 1)
        ->where('category', 'Partner')
        ->get()->sortByDesc('createdDate'));
        $exhibitors = SiteSponsorshipResource::collection(Sponsorship::where('is_visible', 1)
        ->where('category', 'Exhibitor')
        ->get()->sortByDesc('createdDate'));
        if($sponsors){
            return response()->json([
                'message'=> "TAIC Speakers",
                'data' => [
                    'sponsors'=> $sponsors,
                    'partners'=> $partners,
                    'exhibitors'=> $exhibitors,
                ],
                'code' => 200,
            ]);
        }
        return response()->json([
            'message'=> "No data Found",
            'code' => 300,
        ]);
    }

    public function show($id){
        $exists = Sponsorship::where('id', $id)->exists();
        if($exists){
            $tgtSponsorship = Sponsorship::where('id',$id)->get()->first();
            $tgtSponsorship->is_visible = !$tgtSponsorship->is_visible;
            $tgtSponsorship->save();
            return response()->json([
                'message' => 'Visibility switched',
            ]);
        }else{
            return response()->json([
                'message' => 'Sponsorship data not found',
                'data' => null
            ]);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => 'required|min:3',
            "category" => 'required',
            "sub_category" => '',
            "conference_id" => 'required|min:3',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newDataValidated = $validator->validate();
          // Handling files 
          $imageFile = $request->file('imgPath');
          $imageOwnerName = $request->name;
          //Move Uploaded File
          if ($imageFile) {
              $imageFileName = $imageOwnerName. '-'.Str::random(8) . '.' . $imageFile->getClientOriginalExtension();
              $imageFile->move($this->localImgPath, $imageFileName);
          } else {
              $imageFileName = 'noFileUpload.jpg';
          }
          $fileName = [
            'imageFileName' => $imageFileName,
          ];
        $newDataValidated = array_merge($newDataValidated,$fileName);
        $saved_data = Sponsorship::create($newDataValidated);
        return response()->json([
            'message'=> "Conference Sponsor data Created",
            'data' => $saved_data,
            'code'=> 200
        ],200);
    }

    public function update(Request $request, $id){
        $post = Sponsorship::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id){
        Sponsorship::destroy($id);
        return response()->json(null, 204);
    }
}
