<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralCustomHelper;
use App\Helpers\XmlRequestHelper;
use App\Models\Bill;
use App\Models\GatewayBill;
use App\Models\Taic\Conference;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    public function handleBillSubmission(Request $request){
        $external_event = Conference::where('name', 'external_event')->get()->first();
        $external_user = User::where('email', env('MAIL_USERNAME'))->get()->first();
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'phone_number' => 'required|string|min:3', // Validate '+' sign
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'approved_by' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'ccy' => 'required|string|max:3', // 'TZS' should be 3 characters
            'payment_option' => 'required|integer',
            'status_code' => 'required|integer',
            'expires_at' => 'required|date',
            'payment_order_id' => 'required|integer',
            'callback_url' => 'required|url',
        ]);
        // Create a new payment record
        $ext_bill_generated = GatewayBill::create([
            'description' => $validatedData['description'],
            'user_id' => $validatedData['user_id'],
            'phone_number' => $validatedData['phone_number'],
            'customer_name' => $validatedData['customer_name'],
            'customer_email' => $validatedData['customer_email'] ?? null, // Optional field
            'approved_by' => $validatedData['approved_by'],
            'amount' => $validatedData['amount'],
            'ccy' => $validatedData['ccy'],
            'payment_option' => $validatedData['payment_option'],
            'status_code' => $validatedData['status_code'],
            'expires_at' => Carbon::now()->addMonths(8)->format('Y-m-d\TH:i:s'), // Parse date
            'payment_order_id' => $validatedData['payment_order_id'],
            'callback_url' => $validatedData['callback_url'],
        ]);
        $newBill = [
            'user_id' => $external_user->id,
            'conference_id' => $external_event->id,
            'ReqId' =>GeneralCustomHelper::generateReqID(16),
            'customer_name' => $ext_bill_generated->customer_name,
            'billGeneratedBy' => $ext_bill_generated->customer_name,
            'billApproveBy' => 'EMS Billing System',
            'payee_name' => 'ICT Commission',
            'phone_number' => $ext_bill_generated->phone_number,
            'name' => $ext_bill_generated->description,
            'amount' => $ext_bill_generated->amount,
            'reference_no' => GeneralCustomHelper::generateReqID(16),
            'event_fee' => $ext_bill_generated->amount,
            'remarks' => $ext_bill_generated->description,
            'email' => $ext_bill_generated->customer_email,
            'sp_code' => env('GEPG_SPCODE'),
            'GfsCode' => env('GEPG_GSFCODE'),
            'SpGrpCode' => env('GEPG_SPGRPCODE'),
            'bill_exp' => Carbon::now()->addMonths(8)->format('Y-m-d\TH:i:s'),
            'ccy' => "TZS",
            'bill_pay_opt' => 3,
            'status' => 0,
        ];
        try {
            $billData = Bill::create($newBill);
            // Update bill ID
            $ext_bill_generated->bilbill_id = $billData->id;
            $ext_bill_generated->save();

                    $returedXml = XmlRequestHelper::GepgSubmissionRequest($billData);
                    //Check bill is Generated to Gepg
                    if($returedXml){
                            //check for success status
                        $isSuccessful =  GeneralCustomHelper::get_string_between($returedXml, '<AckStsCode>', '</AckStsCode>') == '7101';
                        if($isSuccessful){
                            return response()->json([
                                'message'=> "Bill generated Successful",
                                'data' => $billData,
                                'GepgAck' => $returedXml,
                                'code'=> 200
                            ],200);
                        }
                        else {
                            return response()->json([
                            'message'=> $returedXml ? GeneralCustomHelper::get_string_between($returedXml, '<AckStsDesc>', '</AckStsDesc>'): 'No message',
                            'GepgAck' => $returedXml,
                            'code'=> 300
                        ],500);
                        }

                    }
                    else{
                        return response()->json([
                            'message'=> "Bill Generation failed: Gepg failure",
                            'GepgAck' => $returedXml,
                            'code'=> 300
                        ],500);
                    }
            } 
            catch (\Exception $e){
            return response()->json(
                ['error' => 'Failed to create bill',
            'message' => $e->getMessage(), 'code' => 300]
            , 500);
        }
        // Log::info($request);
    }
}
