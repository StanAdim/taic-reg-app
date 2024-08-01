<?php

namespace App\Helpers;

use App\Models\Bill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class XmlResponseHelper
{
    
    public static function handleResponse($contrlNo_Gepg_res){

        function getXMLData($contrNoXmlData){
            $values = array();
            $values['ResId'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<ResId>', '</ResId>');
            $values['ReqId'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<ReqId>', '</ReqId>');
            $values['BillId'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<BillId>', '</BillId>');
            $values['CustCntrNum'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<CustCntrNum>', '</CustCntrNum>');
            $values['ResStsCode'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<ResStsCode>', '</ResStsCode>');
            $values['ResStsDesc'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<ResStsDesc>', '</ResStsDesc>');
            $values['BillStsDesc'] = GeneralCustomHelper::get_string_between($contrNoXmlData, '<BillStsDesc>', '</BillStsDesc>');
            return $values;
        }

        $PRIVATE_KEY =__DIR__."/gepgclientprivate_2.pfx";
        $KEY_PASSWORD =  env('GEPG_KEYPASS', 'passpass');
        $values = getXMLData($contrlNo_Gepg_res);
        $BillId = $values['BillId'];

        if (strlen($BillId) < 3) {
            $serial = date("YmdHis");
        } else {
            $serial = $BillId;
        }
        // Log::info('RECPAY-GEPG-REQUEST', [$contrlNo_Gepg_res, $serial, 'GEPG']);
        $varray = print_r($values, true);
        Log::info("\n\n----GEPG-VALUES \n", [$varray, $serial, "\nGEPG"]);

        $ResStsCode = $values['ResStsCode'];
        $codes = explode(';', $ResStsCode);

        /// save data based on Request
        Log::info('GEPG', ["----------------------------GEPG\n"]);
        Log::info('GEPG---Response Description', [$values['ResStsDesc']]);
        Log::info('GEPG', ["-----GEPG\n"]);

        /// --- Consuming Gepg Response 
        $NewBillStatus = Bill::where('id',$BillId)->first();
        if (in_array('7279', $codes)) {
            $ResStsCode = 'GEPG-PAID';
            //"UPDATE billing SET gepgstatus='PAID' WHERE billid='$billid'");
            $date = Carbon::now();
            $NewBillStatus->status_code = $ResStsCode;
            $NewBillStatus->paid_date = $date;
            $NewBillStatus->status = 1;
            $NewBillStatus->save();
        }
        elseif (in_array('7101', $codes) OR in_array('7226', $codes))
        {
            //"UPDATE billing SET updated_at='$date',gepgstatus='$ResStsCode',controlno='$controlno' WHERE billid='$billid'");
            $ResStsCode = 'GEPG-OK';
            $cust_cntr_num = $values['CustCntrNum'];
            $NewBillStatus->status_code = $ResStsCode;
            $NewBillStatus->cust_cntr_num = $cust_cntr_num;
            $NewBillStatus->save();            
        }
        else {
            // "UPDATE billing SET gepgstatus='$ResStsCode' WHERE billid='$billid'");
            $NewBillStatus->status_code = $ResStsCode;
            $NewBillStatus->save();  
        }
        
        $codescount = count($codes);
        $error_messages = $codescount . ':';
        for ($i = 0; $i < $codescount; $i++) {
            // $error_messages .= $xsystem->getGEPGErrorMessage($codes[$i]) . '; ';
        }
        Log::info("\n \nRECPAY-GEPG-ERRORS", [$error_messages, $serial, "\nGEPG"]);

        if (!$cert_store = file_get_contents($PRIVATE_KEY)) {
            Log::info("Error: Unable to read the cert file\n");
            exit;
        } else {
            if (openssl_pkcs12_read($cert_store, $cert_info, $KEY_PASSWORD)) {
                 //Response Content Ack  
                $responseContentAck = "<billSubResAck>
                                            <AckId>SP20210205130219</AckId>
                                            <ResId>".$values['ResId']."</ResId>
                                            <AckStsCode>7101</AckStsCode>
                                        </billSubResAck>";
			     //Create signature 
                openssl_sign($responseContentAck, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                // output crypted data base64 encoded
                $signature = base64_encode($signature);
                Log::info("Signature of Signed Content"."\n".$signature."\n");

                // Combine signature and content signed
                $response = "<Gepg>" . $responseContentAck . " <gepgSignature>" . $signature . "</gepgSignature></Gepg>";

                header('Content-type: application/xml');
                Log::info('------,', [$response]);

            }
        }
        Log::info('RECPAY-GEPG-RESPONSE', [$response, $serial, 'GEPG']);
        
    }
        
}
