<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => Auth::id(),
            'event_id' => '',
            'total_amount' => $request->event_fee,
            'status' => 'pending'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
        $storeData = Bill::create($newItem);
        return response()->json([
            'message'=> "New Conference Created",
            'data' => $storeData,
            'code'=> 200
        ],200);
    }
}
