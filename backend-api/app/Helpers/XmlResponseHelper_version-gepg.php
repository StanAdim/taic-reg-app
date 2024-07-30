<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class XmlResponseHelper
{
    
    public static function handleResponse($passedXmlResponse)
    {
        return $passedXmlResponse;

        function getDataString($inputstr,$datatag){
            $datastartpos = strpos($inputstr, $datatag);
            $dataendpos = strrpos($inputstr, $datatag);
            $data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
            return $data;
        }

        function getSignatureString($inputstr,$sigtag){
            $sigstartpos = strpos($inputstr, $sigtag);
            $sigendpos = strrpos($inputstr, $sigtag);
            $signature=substr($inputstr,$sigstartpos + strlen($sigtag)+1,$sigendpos - $sigstartpos -strlen($sigtag)-3);
            return $signature;
        }
                
        if(!empty($passedXmlResponse)){   
            $fileKeyPass = env('GEPG_KEYPASS', 'passpass');

            //Tag for respose
            $datatag = "gepgBillSubResp";
            $sigtag = "gepgSignature";

            $vdata = getDataString($passedXmlResponse,$datatag);
            $vsignature = getSignatureString($passedXmlResponse,$sigtag);

            if (!$pcert_store = file_get_contents(__DIR__."/gepgpubliccertificate.pfx")) {
                Log::info("Error: Unable to read the cert file\n");
                exit;
            }else{

                //Read Certificate
                if (openssl_pkcs12_read($pcert_store,$pcert_info,$fileKeyPass)) {				 

                    //Decode Received Signature String
                    $rawsignature = base64_decode($vsignature);

                    //Verify Signature and state whether signature is okay or not
                    $ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0']);
                    if ($ok == 1) {
                        Log::info("\nResponse Signature Status:");
                        Log::info("Signature Status: GOOD");
                        Log::info("GOOD\n");
                    } elseif ($ok == 0) {
                        Log::info("\nResponse Signature Status:");
                        Log::info("BAD\n");
                    } else {
                        Log::info("\n\n Response Signature Status:");
                        Log::info("UGLY, Error checking signature");
                    }

                }  
            }
            
            
        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate_2.pfx")) {
            Log::info("Error: Unable to read the cert file\n");
            exit;
        }else{
            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass))
                    {
                    //Response Content Ack  
                    $responseContentAck ="<gepgBillSubRespAck><TrxStsCode>7101</TrxStsCode></gepgBillSubRespAck>";
                    //Create signature 
                    openssl_sign($responseContentAck, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");
                    $signature = base64_encode($signature);
                    //Compose  response request
                    $data = "<Gepg>".$responseContentAck."<gepgSignature>".$signature."</gepgSignature></Gepg>";
                    }
                    return $data;                         
   
            }
                
        }

    }
        
}
