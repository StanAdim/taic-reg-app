<?php

namespace App\Http\Controllers;

use App\Http\Resources\Taic\BillResource;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    public function userBill()
    {
        $bills = BillResource::collection(Auth::user()->bills);
        return response()->json([
            'message'=> "All your bills",
            'data' => $bills,
            'code'=> 200
        ],200);
    }
}
