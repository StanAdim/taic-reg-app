<?php

namespace App\Helpers;

use App\Models\Bill;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class XmlResponseHelper
{
    
    public static function handleResponse($contrlNo_Gepg_res){

        $gepg_response = GeneralCustomHelper::contrNoXmlResToArray($contrlNo_Gepg_res);
        $BillId = $gepg_response['BillId'];

        if (strlen($BillId) < 3) {
            $serial = date("YmdHis");
        } else {
            $serial = $BillId;
        }
        // Log::info('RECPAY-GEPG-REQUEST', [$contrlNo_Gepg_res, $serial, 'GEPG']);
        $varray = print_r($gepg_response, true);
        Log::info("\n\n---------------GEPG Control number \n", [$varray, $serial, "\n -------GEPG"]);

        $ResStsCode = $gepg_response['ResStsCode'];
        $codes = explode(';', $ResStsCode);

        /// save data based on Request

        //--- Consuming Gepg Response 
            try {
                $exists = Bill::where('id', $BillId)->exists();
                if($exists){
                    $theBill = Bill::where('id',$BillId)->first();
                        if (in_array('7279', $codes)) {
                            $ResStsCode = 'GEPG-PAID';
                            //"UPDATE billing SET gepgstatus='PAID' WHERE billid='$billid'");
                            $date = Carbon::now();
                            $theBill->status_code = $ResStsCode;
                            $theBill->paid_date = $date;
                            $theBill->status = 1;
                            $theBill->save();
                        }
                        elseif (in_array('7101', $codes) OR in_array('7226', $codes)) {
                            //"UPDATE billing SET updated_at='$date',gepgstatus='$ResStsCode',controlno='$controlno' WHERE billid='$billid'");
                            $ResStsCode = 'GEPG-OK';
                            $cust_cntr_num = $gepg_response['CustCntrNum'];
                            $theBill->status_code = $ResStsCode;
                            $theBill->cust_cntr_num = $cust_cntr_num;
                            $theBill->save();            
                        }
                        else {
                            // "UPDATE billing SET gepgstatus='$ResStsCode' WHERE billid='$billid'");
                            $theBill->status_code = $ResStsCode;
                            $theBill->save();  
                        }
                         // Signing response
                        return GeneralCustomHelper::signedBillAck($gepg_response['ResId'],7101);
                        // Log::info('RECPAY-GEPG-RESPONSE', [$response, $serial, 'GEPG']);
                }
                
            } catch (QueryException $e) {
                // Handle the exception
                echo "Error occurred: " . $e->getMessage();
                // Optionally, log the error
                Log::error('Database query error', ['exception' => $e]);
                return GeneralCustomHelper::signedBillAck($gepg_response['ResId'],7303);
            }

    }
        
}
