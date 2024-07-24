<?php

namespace App\Http\Controllers;

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
        // Received Data
        $xmlData = $request->getContent();
       // Parse the XML data
       try {
        $xml = simplexml_load_string($xmlData, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        // Extract relevant data from parsed array
        $billTrxInf = $array['BillTrxInf'];
        $billId = $billTrxInf['BillId'];
        $trxSts = $billTrxInf['TrxSts'];
        $payCntrNum = $billTrxInf['PayCntrNum'];
        $trxStsCode = $billTrxInf['TrxStsCode'];

        // Find the Bill by BillId and update it
        $bill = Bill::where('id', $billId)->first();
        if ($bill) {
            if (strlen($bill->id) < 3) { $serial = date("YmdHis");} 
            else { $serial = $bill->id;}
            Log::info('RECPAY-GEPG-REQUEST', [$request, $serial, 'GEPG']);
            $varray = print_r($xmlData, true);
            Log::info('RECPAY-GEPG-VALUES', [$varray, $serial, 'GEPG']);
     
            $statuscodes = $trxStsCode;
            $codes = explode(';', $statuscodes);
            if (in_array('7279', $codes)) {
                $statuscodes = 'GEPG-PAID';
                #mysqli_query($xdatabase->xdb, "UPDATE transactions SET bill='$statuscodes',tstatus='PAID' WHERE billid='$billid'");
                // mysqli_query($xdatabase->xdb, "UPDATE billing SET gepgstatus='PAID' WHERE billid='$billid'");
                $bill->update([
                    'status_code' => $statuscodes,
                ]);
        
            }
            elseif (in_array('7101', $codes) || in_array('7226', $codes))
            {
                $statuscodes = 'GEPG-OK';
                $controlno = $payCntrNum;
                $date = Carbon::now();
                //mysqli_query($xdatabase->xdb, "UPDATE transactions SET bill='$statuscodes',controlno='$controlno' WHERE billid='$billid'");
                // mysqli_query($xdatabase->xdb, "UPDATE billing SET updated_at='$date',gepgstatus='$statuscodes',controlno='$controlno' WHERE billid='$billid'");
                $bill->update([
                    'cust_cntr_num' => $controlno,
                    'status_code' => $statuscodes,
                ]);
            }
            else {
                //mysqli_query($xdatabase->xdb, "UPDATE transactions SET bill='$statuscodes' WHERE billid='$billid'");
                // mysqli_query($xdatabase->xdb, "UPDATE billing SET gepgstatus='$statuscodes' WHERE billid='$billid'");
                $bill->update([
                    'status_code' => $statuscodes,
                ]);
            }
        } else {
            Log::info('Bill Fail to update', ['--Faile---']);
            return response()->json([
                'status' => 'error',
                'message' => 'Bill not found'
            ], 404);
        }

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid XML data',
            'error' => $e->getMessage()
        ], 400);
    }

        // Assuming you want to return a response to the external service
        return response()->json(['status' => 'success'], 200);
       
   }

}
