<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralCustomHelper;
use App\Helpers\XmlRequestHelper;
use App\Helpers\XmlResponseHelper;
use App\Http\Resources\Taic\BillResource;
use App\Models\Bill;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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
    public function index(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12); 
        // Build the query for fetching bills
        $query = Bill::query()->orderBy('created_at', 'desc');
        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ReqId', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%"); // Add other fields for search if needed
            });
        }
        // Paginate the results
        $pagenated_bills = $query->paginate($perPage);
        // Transform the paginated result into resources
        $bills = BillResource::collection($pagenated_bills);
    
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

    public function settledBills(Request $request){
        // Fetch the search term from the request (optional)
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12); 
        // Build the query for fetching bills
        $query = Bill::query()->where('status', 1)->orderBy('created_at', 'desc');        // Apply search if there is a search term
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('ReqId', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%"); // Add other fields for search if needed
            });
        }
        // Paginate the results
        $pagenated_bills = $query->paginate($perPage);
        // Transform the paginated result into resources
        $bills = BillResource::collection($pagenated_bills);
    
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
            'message' => "No payment is found",
            'code' => 300,
        ]);
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
    public function handleReconciliationRequest(Request $request)  {
        // Calculate the range
        $yesterday = Carbon::yesterday();
        $sevenDaysAgo = $yesterday->copy()->subDays(7);

        // Validate the date
        $request->validate([
            'reconciliation_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($sevenDaysAgo, $yesterday) {
                    $date = Carbon::parse($value);
                    if ($date->lt($sevenDaysAgo) || $date->gt($yesterday)) {
                        $fail("The {$attribute} must be between {$sevenDaysAgo->format('Y-m-d')} and {$yesterday->format('Y-m-d')}.");
                    }
                },
            ],
        ]);        // Now you can format the date as needed
        $reconcile_date = Carbon::parse($request->input('reconciliation_date'));
        $reconcile_date = $reconcile_date->format('Y-m-d'); //Format
        // process reconcilation 
        try{
            $dataResult = XmlRequestHelper::GepgReconciliationRequest($reconcile_date);
            return response()->json([
                'message'=> $dataResult ? GeneralCustomHelper::get_string_between($dataResult, '<AckStsDesc>', '</AckStsDesc>'): 'No message',
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

    public function generateInvoice($type, $user_bill){
        try {
            $bank_details = [];
            $crdb = [
                'name' => 'CRDB Bank PLC',
                'account' => '0150439329500',
                'swft_code' => 'CORUTZTZ',
                'beneficiary' => 'ICT Commission GePG Collection Account'
            ];
            $nmb = [
                'name' => 'National Microfinance Bank (NMB)',
                'account' => '20110057839',
                'swft_code' => 'NIMBTZTZ',
                'beneficiary' => 'ICT Commission GePG Collection Account'
            ];
          

            $bill_data = Bill::where('id', $user_bill)->first();
            if (!$bill_data) {
                return response()->json([
                    'message' => "Bill not found"
                ], 404);
            }

            // Path to the logo
            $logoPath = public_path('images/nembo.png');

            // Generate the QR code with a logo
            $qr_json = [
                "opType"=>"2",
                "shortCode"=>"001001",
                "billReference"=>$bill_data->reference_no,
                "amount"=>$bill_data->amount,
                "billCcy"=>$bill_data->ccy,
                "billExprDt"=>$bill_data->bill_exp,
                "billPayOpt"=>$bill_data->bill_pay_opt,
                "billRsv01"=>"",
            ];
            $qrData = json_encode($qr_json);

            $qrCode = QrCode::size(100)
                            ->merge($logoPath, 0.3, true) // 0.3 indicates 30% of the QR code size, adjust as needed
                            ->generate($qrData ?? 0);
            
            switch ($type) {
                case 1:
                    if (!$bill_data->status) {
                        // Unsettle Bill Invoice
                        $pdf = FacadePdf::loadView('pdf.invoice', ['bill_data' => $bill_data, 'qrCode' => $qrCode]);
                    } else {
                        // Settled Bill Receipt
                        $pdf = FacadePdf::loadView('pdf.receipt', ['bill_data' => $bill_data, 'qrCode' => $qrCode]);
                    }
                    break;
                case 2:
                    $bank_details = $crdb;
                    $pdf = FacadePdf::loadView('pdf.remitter', ['bill_data' => $bill_data, 'bank_details' => $bank_details, 'qrCode' => $qrCode]);
                    break;
                case 3:
                    $bank_details = $nmb;
                    $pdf = FacadePdf::loadView('pdf.remitter', ['bill_data' => $bill_data, 'bank_details' => $bank_details, 'qrCode' => $qrCode]);
                    break;
                default:
                    return response()->json([
                        'message' => "Request Type not found"
                    ], 404);
            }

            return $pdf->download($bill_data->ReqId . '-ems-bill.pdf');
        } catch (Exception $e) {
            return response()->json([
                'message' => "Failed to generate invoice: " . $e->getMessage(),
            ], 500);
        }
    }
    public function generateCustomQrCode(){
       return "test";
    }

}
