<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfessinalResource;
use App\Models\Professional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function getProfessionalDetails(Request $request){
        $query = $request->input('reg_number');
        $query = strtoupper(trim($query));
        $result = ProfessinalResource::collection(Professional::where('RegNo' , $query)->get())->first();
    if ($result != []) {
        return response()->json([
            'message' => 'Success Fetching Professional',
            'data' => $result
        ],200);
    } else {
        return response()->json([
            'message' => 'Reg Number Not found',
        ],404);
    }
}
}
