<?php

namespace App\Http\Controllers\Taic;

use App\Http\Controllers\Controller;
use App\Http\Resources\Taic\ConferenceResource;
use App\Models\Taic\Conference;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function fetchSiteData(){
        $activeConference = ConferenceResource::collection(Conference::where('lock', 1)->get())->first();
        if($activeConference){
            return response()->json([
                'message'=> 'Site Data Fetched',
                'code' => 200,
                'data' => $activeConference
            ]);
        }
        return response()->json([
            'message'=> 'No Data Fetched',
            'code' => 300,
        ]);
    }
}
