<?php

namespace App\Helpers;

use App\Models\Bill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class XmlResponseHelper
{
    
    public static function handleResponse($passedXmlResponse){

        function getXMLData($passedXmlResponse){
            $values = array();
            $values['ResId'] = get_string_between($passedXmlResponse, '<ResId>', '</ResId>');
            $values['ReqId'] = get_string_between($passedXmlResponse, '<ReqId>', '</ReqId>');
            $values['BillId'] = get_string_between($passedXmlResponse, '<BillId>', '</BillId>');
            $values['CustCntrNum'] = get_string_between($passedXmlResponse, '<CustCntrNum>', '</CustCntrNum>');
            $values['ResStsCode'] = get_string_between($passedXmlResponse, '<ResStsCode>', '</ResStsCode>');
            $values['ResStsDesc'] = get_string_between($passedXmlResponse, '<ResStsDesc>', '</ResStsDesc>');
            $values['BillStsDesc'] = get_string_between($passedXmlResponse, '<BillStsDesc>', '</BillStsDesc>');
            return $values;
        }

        function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

        $PRIVATE_KEY =__DIR__."/gepgpubliccertificate.pfx";
        $KEY_PASSWORD =  env('GEPG_KEYPASS', 'passpass');
        $values = getXMLData($passedXmlResponse);
        $BillId = $values['BillId'];

        if (strlen($BillId) < 3) {
            $serial = date("YmdHis");
        } else {
            $serial = $BillId;
        }
        // Log::info('RECPAY-GEPG-REQUEST', [$passedXmlResponse, $serial, 'GEPG']);
        $varray = print_r($values, true);
        Log::info('RECPAY-GEPG-VALUES', [$varray, $serial, 'GEPG']);

        $ResStsCode = $values['ResStsCode'];
        $codes = explode(';', $ResStsCode);

        /// save data based on Request
        Log::info('GEPG', ["----------------------------GEPG\n"]);
        Log::info('GEPG---Response Description', [$values['ResStsDesc']]);
        Log::info('GEPG', ["-----GEPG\n"]);

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


        Log::info('RECPAY-GEPG-ERRORS', [$error_messages, $serial, 'GEPG']);

        if (!$cert_store = file_get_contents($PRIVATE_KEY)) {
            Log::info("Error: Unable to read the cert file\n");
            exit;
        } else {
            if (openssl_pkcs12_read($cert_store, $cert_info, $KEY_PASSWORD)) {
                 //Response Content Ack  
                $responseContentAck = "<billSubResAck>
                                            <AckId>SP20210205130219</AckId>
                                            <ResId>GW20210205130219</ResId>
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
