<?php

namespace App\Http\Controllers;

use App\Helpers\XmlRequestHelper;
use App\Helpers\XmlResponseHelper;
use App\Http\Resources\Taic\BillResource;
use App\Models\Bill;
use Carbon\Carbon;
use Exception;
use Generator;
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

    // Handle the receipt of Control number
    public function receiveControlNumber(Request $request)  {
        // process response 
        $dataResult = XmlResponseHelper::handleContrlNoResponse($request->getContent());
        return $dataResult;
        
   }

   //deal with payments receipt 
   public function handlePayment(Request $request)  {
    // process response 
    $dataResult = XmlResponseHelper::handlePaymentReceipt($request->getContent());
    return $dataResult;
    
    }

    //Handle response on Reconcile request
   public function handleGepgReconcileRes(Request $request)  {
    // process response 
    $dataResult = XmlResponseHelper::handleReconcileReceipt($request->getContent());
    return $dataResult;
    }

    // user request reconciliation
    public function handleReconciliationRequest($bill_id)  {
        // process reconcilation 
        try{
            $theBill = Bill::where('id', $bill_id)->firstOrFail();
            $dataResult = XmlRequestHelper::GepgReconciliationRequest($theBill);
            return $dataResult;
        }catch(Exception $e){
            return $e->getMessage();
        }
        
    }
    public function handleCancellationRequest($bill_id)  {
        // process response 
        $user = Auth::user();
        try{
            $theBill = Bill::where('id', $bill_id)->firstOrFail();
            $dataResult = XmlRequestHelper::GepgCancellationRequest($theBill, $user);

            return $dataResult;
        }catch(Exception $e){
            return $e;
        }
        
    }

}
