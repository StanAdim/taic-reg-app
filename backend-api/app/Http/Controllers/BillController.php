<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralCustomHelper;
use App\Helpers\XmlRequestHelper;
use App\Helpers\XmlResponseHelper;
use App\Http\Resources\Taic\BillResource;
use App\Models\Bill;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    public function userBill()
    {
        $bills = BillResource::collection(Auth::user()->bills->sortByDesc('created_at'));
        return response()->json([
            'message'=> "All your bills",
            'data' => $bills,
            'code'=> 200
        ],200);
    }
    public function index()
    {
        $bills = BillResource::collection(Bill::all()->sortByDesc('created_at'));
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
    public function handleReconciliationRequest($passedReconDate)  {
        $date = Carbon::parse($passedReconDate);
        // Now you can format the date as needed
        $reconcile_date = $date->format('Y-m-d'); //Format
        // process reconcilation 
        try{
            // $theBill = Bill::where('id', $bill_id)->firstOrFail();
            $dataResult = XmlRequestHelper::GepgReconciliationRequest($reconcile_date);
            return response()->json([
                'message'=> 'Reconciliation Request Sent',
                'gepg_message'=> $dataResult ? GeneralCustomHelper::get_string_between($dataResult, '<AckStsDesc>', '</AckStsDesc>'): 'No message',
                'data'=> $dataResult,
            ]);
        }catch(Exception $e){
            return response()->json([
                'message'=> 'Error while Sending Request',
                'error'=> $e->getMessage(),
            ]); 
        }
        
    }
    public function handleCancellationRequest($bill_id)  {
        // process response 
        $user = Auth::user();
        try{
            $theBill = Bill::where('id', $bill_id)->firstOrFail();
            $dataResult = XmlRequestHelper::GepgCancellationRequest($theBill, $user);
            return response()->json([
                'message'=> 'Cancellation Request Sent',
                'gepg_message'=> $dataResult ? GeneralCustomHelper::get_string_between($dataResult, '<CanclStsDesc>', '</CanclStsDesc>'): 'No message',
                'data'=> $dataResult,
            ]);
        }catch(Exception $e){
            return response()->json([
                'message'=> 'Error while Sending Request',
                'error'=> $e->getMessage(),
            ]); 
               
        }
        
    }

}
