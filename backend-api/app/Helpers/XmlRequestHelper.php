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

        $bill_exp = Carbon::now()->addMonths(8)->format('Y-m-d\TH:i:s');
        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate_2.pfx")) {
            Log::info(["\n\n --------Error: \n *** Unable to read the cert file\n"]);
            exit;
        }
        else
        {
            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass)){
                //Bill Request
                $id = $billingData->id;
                $spcode =env('GEPG_SPCODE');
                $systemid =env('GEPG_SYSTEMID');

                $reqID = GeneralCustomHelper::generateReqID(16);
                $genDate = GeneralCustomHelper::getGenerationDate();
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
                                <CustIdTyp>5</CustIdTyp>
                                <CustAccnt>".GeneralCustomHelper::formatThePhoneNumber($billingData->phone_number)."</CustAccnt>
                                <CustName>".$billingData->name."</CustName>
                                <CustCellNum>".GeneralCustomHelper::formatThePhoneNumber($billingData->phone_number)."</CustCellNum>
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
                Log::info("\n ======= Curl Send payload GEPG");
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
                Log::info("\n\n===END MESSAGEING GEPG");

                $resultCurlPost = curl_exec($ch);
                curl_close($ch);
                Log::info("\n\n ### Response Data Length:\n",[strlen($resultCurlPost)]);
                
                if(!empty($resultCurlPost)){
                    Log::info("\n\n-----Response Results: \n###",[GeneralCustomHelper::get_string_between($resultCurlPost, '<AckStsCode>', '</AckStsCode>')]);
                    Log::info("\n\n-----Response Results: \n###",[GeneralCustomHelper::get_string_between($resultCurlPost, '<AckStsCode>', '</AckStsCode>')]);
                    Log::info("\n\n---- Response End---");

                    $vdata = GeneralCustomHelper::get_string_between($resultCurlPost, '<Gepg>', '<signature>');
                    $vsignature = GeneralCustomHelper::get_string_between($resultCurlPost, '<signature>', '</signature>');
                    
                    //Get Certificate contents
                    if (!$pcert_store = file_get_contents(__DIR__."/gepgpubliccertificate.pfx")) {
                        Log::info("---Error: Unable to read the cert file\n");
                        exit;
                    }else{
                        //Read Certificate
                        if (openssl_pkcs12_read($pcert_store, $pcert_info, $fileKeyPass)) {
                            //Decode Received Signature String
                            $rawsignature = base64_decode($vsignature);
                            //Verify Signature and state whether signature is okay or not
                            $ok = openssl_verify($vdata, $rawsignature, $pcert_info['extracerts']['0'], OPENSSL_ALGO_SHA256);
                            if ($ok == 1) {
                                Log::info("\n\n------Signature Status: GOOD");
                                Log::info("\n\n---- End Verification ---");
                                return $vdata;
                            } elseif ($ok == 0) {
                                Log::info("----Signature Status: BAD");
                                return false;
                            } else { 
                                Log::info("Signature Status: UGLY, Error checking signature:"); 
                            }
                        }
                    }
                }
                else{ Log::info("No result Returned"."\n");}
                
            }
            else
            { Log::info("Error: Unable to read the cert store.\n"); exit;}
        }

    }


}
