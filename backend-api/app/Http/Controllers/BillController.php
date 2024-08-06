<?php

namespace App\Http\Controllers;

use App\Helpers\XmlResponseHelper;
use App\Http\Resources\Taic\BillResource;
use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    public function index()
    {
        $bills = BillResource::collection(Bill::all());
        return response()->json([
            'message'=> "All bills",
            'data' => $bills,
            'code'=> 200
        ],200);
    }

    public function receiveControlNumber(Request $request)  {
        // process response 
        $dataResult = XmlResponseHelper::handleContrlNoResponse($request->getContent());
        return $dataResult;
        
   }

   public function handlePayment(Request $request)  {
    // process response 
    $dataResult = XmlResponseHelper::handlePaymentReceipt($request->getContent());
    return $dataResult;
    
}

}
