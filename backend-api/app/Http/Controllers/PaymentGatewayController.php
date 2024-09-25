<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralCustomHelper;
use App\Helpers\XmlRequestHelper;
use App\Http\Resources\GatewayBillResource;
use App\Models\Bill;
use App\Models\GatewayBill;
use App\Models\GatewaySystem;
use App\Models\Taic\Conference;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{

    public function registeredSystem(){
        $data_req = GatewaySystem::all();
        return response()->json([
            'message' => 'System registered',
            'data' => $data_req,
        ]);
    }
    public function index(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12); 
        // Build the query for fetching bills
        $query = GatewayBill::query()->orderBy('created_at', 'desc');
        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%"); // Add other fields for search if needed
            });
        }
        // Paginate the results
        $pagenated_bills = $query->paginate($perPage);
        // Transform the paginated result into resources
        $bills = GatewayBillResource::collection($pagenated_bills);
    
        if ($pagenated_bills->isNotEmpty()) {
            return response()->json([
                'message' => "Application bills",
                'data' => $bills,
                'pagination' => [
                    'current_page' => $pagenated_bills->currentPage(),
                    'last_page' => $pagenated_bills->lastPage(),
                    'per_page' => $pagenated_bills->perPage(),
                    'total' => $pagenated_bills->total(),
                    'next_page_url' => $pagenated_bills->nextPageUrl(),
                    'prev_page_url' => $pagenated_bills->previousPageUrl(),
                ],
                'code' => 200,
            ]);
        }
        return response()->json([
            'message' => "No bills found",
            'code' => 300,
        ]);
    }
    public function handleBillSubmission(Request $request){
        $external_event = Conference::where('name', 'external_event')->get()->first();
        $external_user = User::where('email', env('MAIL_USERNAME'))->get()->first();
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'uuid' => 'required',
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
            'system_code' => 'required',
        ]);

        $isAllowedSystem = GatewaySystem::where('code',$validatedData['system_code'])->first();
        // Create a new payment record
        if($isAllowedSystem){
            $ext_bill_generated = GatewayBill::create([
                'description' => $validatedData['description'],
                'uuid' => $validatedData['uuid'],
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
                'system_code' => $validatedData['system_code'],
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
                $ext_bill_generated->bill_id = $billData->id;
                $ext_bill_generated->save();
                // submission of Bill to gepg
                        $returedXml = XmlRequestHelper::GepgSubmissionRequest($billData);
                        //Check bill is Generated to Gepg
                        Log:info(['return-gepg-', $returedXml]);
                        if($returedXml){
                                //check for success status
                            $isSuccessful =  GeneralCustomHelper::get_string_between($returedXml, '<AckStsCode>', '</AckStsCode>') == '7101';
                            if($isSuccessful){
                                return response()->json([
                                    'message'=> "Bill generated Successful",
                                    'data' => [
                                        'bill_reference_id' => $billData->id
                                    ],
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
        else{
            return response()->json([
                'message' => 'Error in System Code',
            ], 500);
        }
    }
    // create system
    public function addNewSystem(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'callback_controll_number' => 'required|string|max:100',
            'callback_payment_number' => 'required|string|max:100',
            'callback_reconcilliation' => 'required|string|max:100',
            'callback_addition' => 'required|string|max:100',
            'base_url' => 'required|url',
        ]);
        
        $newSystem = GatewaySystem::create($validated);
        return response()->json([
            'message' => 'New system added',
            'data' => $newSystem
        ], 201);
    }

    // Update an existing Example
    public function updateSystem(Request $request, GatewaySystem $updatedSystem)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'sometimes|required|string|max:50',
            'description' => 'nullable|string',
            'callback_controll_number' => 'sometimes|required|string|max:100',
            'callback_payment_number' => 'sometimes|required|string|max:100',
            'callback_reconcilliation' => 'sometimes|required|string|max:100',
            'callback_addition' => 'sometimes|required|string|max:100',
            'base_url' => 'sometimes|required|url',
        ]);
        $updatedSystem->update($validated);
        return response()->json([
            'message' => 'New system added',
            'data' => $updatedSystem
        ], 200);
    }
}
