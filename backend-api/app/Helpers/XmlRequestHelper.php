<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class XmlRequestHelper
{
    
    public static function GepgSubmissionRequest($billingData)
    {
        $fileKeyPass = env('GEPG_KEYPASS', 'passpass');
        $GepgBaseUrl = env('GEPG_BASEURL');
        $requestUri = env('GEPG_SUBMISSIONURI');
        $collectionCenCode = env('GEPG_COLLECTIONCENCODE');
        $Gsfcode = env('GEPG_GSFCODE');
        $SubSpCode = env('GEPG_SUBSPCODE');
        //Function to get Data string
        // app/Helpers/gepgclientprivate_2.pfx


        function generateReqID($length=16) {
            $randomNumberString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomNumberString .= mt_rand(0, 9);
            }
            return $randomNumberString;
        }

        function getGenerationDate() {
            $date = Carbon::now();
            $formattedDate = $date->format('Y-m-d\TH:i:s');
            return $formattedDate;
        }

        function getDataString($inputstr,$datatag){
            $datastartpos = strpos($inputstr, $datatag);
            $dataendpos = strrpos($inputstr, $datatag);
            $data=substr($inputstr,$datastartpos - 1,$dataendpos + strlen($datatag)+2 - $datastartpos);
            return $data;
        }
        //Function to get Signature string
        function getSignatureString($inputstr,$sigtag){
            $sigstartpos = strpos($inputstr, $sigtag);
            $sigendpos = strrpos($inputstr, $sigtag);
            $signature=substr($inputstr,$sigstartpos + strlen($sigtag)+1,$sigendpos - $sigstartpos -strlen($sigtag)-3);
            return $signature;
        }
        // Check if the string starts with '+225'
        function formatThePhoneNumber($str) {
            if (substr($str, 0, 4) === '+225') {
                // Remove the '+' sign and return the rest of the string
                return '225' . substr($str, 4);
            }
            // Return null if the string does not start with '+225'
            return 255738171742;
        }

        $bill_exp = Carbon::now()->addMonths(8)->format('Y-m-d\TH:i:s');

        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate_2.pfx")) {
            Log::info(["Error: Unable to read the cert file\n"]);
            exit;
        }
        else
        {
            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass))
            {
                //Bill Request
                $id = $billingData->id;
                $spcode =env('GEPG_SPCODE');
                $systemid =env('GEPG_SYSTEMID');

                $reqID = generateReqID(16);
                $genDate = getGenerationDate();
                $content ="<billSubReq>
                        <BillHdr>
                            <ReqId>".$reqID."</ReqId>
                            <SpGrpCode>".$spcode."</SpGrpCode>
                            <SysCode>".$systemid."</SysCode>
                            <BillTyp>1</BillTyp>
                            <PayTyp>2</PayTyp>
                            <GrpBillId>".$id."</GrpBillId>
                        </BillHdr>
                        <BillDtls>
                            <BillDtl>
                                <BillId>".$id."</BillId>
                                <SpCode>".$spcode."</SpCode>
                                <CollCentCode>".$collectionCenCode."</CollCentCode>
                                <BillDesc>".$billingData->name."</BillDesc>
                                <CustTin>111111111</CustTin>
                                <CustId>".$billingData->user_id."</CustId>
                                <CustIdTyp>1</CustIdTyp>
                                <CustAccnt>".formatThePhoneNumber($billingData->phone_number)."</CustAccnt>
                                <CustName>".$billingData->name."</CustName>
                                <CustCellNum>".formatThePhoneNumber($billingData->phone_number)."</CustCellNum>
                                <CustEmail>".$billingData->email."</CustEmail>
                                <BillGenDt>".$genDate."</BillGenDt>
                                <BillExprDt>".$bill_exp."</BillExprDt>
                                <BillGenBy>".$billingData->billGeneratedBy."</BillGenBy>
                                <BillApprBy>".$billingData->billApproveBy."</BillApprBy>
                                <BillAmt>".$billingData->amount."</BillAmt>
                                <BillEqvAmt>".$billingData->amount."</BillEqvAmt>
                                <MinPayAmt>".$billingData->amount."</MinPayAmt>
                                <Ccy>".$billingData->ccy."</Ccy>
                                <ExchRate>1.0</ExchRate>
                                <BillPayOpt>1</BillPayOpt>
                                <PayPlan>1</PayPlan>
                                <PayLimTyp>1</PayLimTyp>
                                <PayLimAmt>0.00</PayLimAmt>
                                <CollPsp/>
                                <BillItems>
                                    <BillItem>
                                        <RefBillId>".$id."</RefBillId>
                                        <SubSpCode>".$SubSpCode."</SubSpCode>
                                        <GfsCode>".$Gsfcode."</GfsCode>
                                        <BillItemRef>".$id."</BillItemRef>
                                        <UseItemRefOnPay>N</UseItemRefOnPay>
                                        <BillItemAmt>".$billingData->amount."</BillItemAmt>
                                        <BillItemEqvAmt>".$billingData->amount."</BillItemEqvAmt>
                                        <CollSp>".$spcode."</CollSp>
                                    </BillItem>
                                </BillItems>
                                </BillDtl>
                        </BillDtls>
                    </billSubReq>";


                //create signature
                openssl_sign($content, $signature, $cert_info['pkey'], "sha256WithRSAEncryption");
                //output crypted data base64 encoded
                $signature = base64_encode($signature);
                //Combine signature and content signed
                $data = "<Gepg>".$content."<signature>".$signature."</signature></Gepg>";

                $resultCurlPost = "";
                $serverIp = $GepgBaseUrl;
                $uri = $requestUri;


                $data_string = $data;
                Log::info("\n __________---  MESSAGING GEPG --__________-----");
                Log::info("\n ----Message Length:",[strlen($data_string)]);

                $ch = curl_init($serverIp.$uri);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type:application/xml',
                        'Gepg-Com:default.sp.in',
                        'Gepg-Code:'.$spcode,
                        'Gepg-Alg:00S2',
                        'Content-Length:'.strlen($data_string))
                );

                curl_setopt($ch, CURLOPT_TIMEOUT, 70);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 70);
                Log::info("\n\n__________--- END MESSAGEING GEPG --__________----- ");

                $resultCurlPost = curl_exec($ch);
                curl_close($ch);
                Log::info("\n \n __________---  RESULTING GEPG --__________----- ");

                Log::info("\nResponse Data Length:",[strlen($resultCurlPost)]);

                Log::info("\n ####### \n Response Data \n ################ \n ####### \n \n",[$resultCurlPost]);

                Log::info("\n \n __________--- END RESULT GEPG --__________----- ");
                
                if(!empty($resultCurlPost)){
                    Log::info("\nResponse Data Length: ################ \n",[strlen($resultCurlPost)]);

                    //Tags used in substring response content
                    $datatag = "billSubReqAck";
                    $sigtag = "signature";

                    //Get data and signature from response
                    $vdata = getDataString($resultCurlPost,$datatag);
                    $vsignature = getSignatureString($resultCurlPost,$sigtag);

                    //Get Certificate contents
                    if (!$pcert_store = file_get_contents(__DIR__."/gepgpubliccertificate.pfx")) {
                        Log::info("Error: Unable to read the cert file\n");
                        exit;
                    }else{
                        //Read Certificate
                        if (openssl_pkcs12_read($pcert_store, $pcert_info, "passpass")) {
                            //Decode Received Signature String
                            $rawsignature = base64_decode($vsignature);

                            //Verify Signature and state whether signature is okay or not
                            $ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0']);
                            if ($ok == 1) {
                                echo "Signature Status:";
                                Log::info("Signature Status: GOOD");
                            } elseif ($ok == 0) {
                                Log::info("Signature Status: BAD");
                            } else {
                                Log::info("Signature Status: UGLY, Error checking signature");

                            }
                            
                        }
                    }
                    try{
                        $xml = simplexml_load_string($resultCurlPost, "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = json_encode($xml);
                        $arrayFromXml = json_decode($json,TRUE);
                        Log::info("\nResponse Data:\n ################ \n", [$arrayFromXml]);
                        Log::info("\n \n __________--- END --__________----- ");
                        return $arrayFromXml;
                    }
                    catch (\Exception $e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Invalid XML data',
                            'error' => $e->getMessage()
                        ], 400);
                    }
                }
                else{  Log::info("No result Returned"."\n");}

            }
            else
            { Log::info("Error: Unable to read the cert store.\n"); exit;}
        }

    }


}
