<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class XmlRequestHelper
{
    public static function GepgSubmissionRequest($billingData)
    {
        // dd($billingData);
        $fileKeyPass = "passpass";
        $GepgBaseUrl = "https://uat1.gepg.go.tz";
        $requestUri = "/api/bill/20/submission";
        //Function to get Data string
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

        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate.pfx")) {
            Log::info("Error: Unable to read the cert file\n");
            exit;
        }
        else
        {
            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass))
            {
                //Bill Request
                $id = $billingData->id;
                $spcode ="SP19912";
                $systemid ="TICTC001";
                $content ="<billSubReq>
                        <BillHdr>
                            <ReqId>1321307376409088</ReqId>
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
                                <CollCentCode>HQ</CollCentCode>
                                <BillDesc>certificate invoice</BillDesc>
                                <CustTin>111111111</CustTin>
                                <CustId>111111111</CustId>
                                <CustIdTyp>4</CustIdTyp>
                                <CustAccnt>255657871769</CustAccnt>
                                <CustName>maasai furniture</CustName>
                                <CustCellNum>255657871769</CustCellNum>
                                <CustEmail>maasai@gmail.com</CustEmail>
                                <BillGenDt>2024-02-08T10:13:29</BillGenDt>
                                <BillExprDt>2024-02-22T10:13:29</BillExprDt>
                                <BillGenBy>maasai furniture</BillGenBy>
                                <BillApprBy>maasai furniture</BillApprBy>
                                <BillAmt>100000.00</BillAmt>
                                <BillEqvAmt>100000.00</BillEqvAmt>
                                <MinPayAmt>100000.00</MinPayAmt>
                                <Ccy>TZS</Ccy>
                                <ExchRate>1.0</ExchRate>
                                <BillPayOpt>1</BillPayOpt>
                                <PayPlan>1</PayPlan>
                                <PayLimTyp>1</PayLimTyp>
                                <PayLimAmt>0.00</PayLimAmt>
                                <CollPsp/>
                                <BillItems>
                                    <BillItem>
                                        <RefBillId>".$id."</RefBillId>
                                        <SubSpCode>1001</SubSpCode>
                                        <GfsCode>140101</GfsCode>
                                        <BillItemRef>".$id."</BillItemRef>
                                        <UseItemRefOnPay>N</UseItemRefOnPay>
                                        <BillItemAmt>100000.00</BillItemAmt>
                                        <BillItemEqvAmt>100000.00</BillItemEqvAmt>
                                        <CollSp>SP19928</CollSp>
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
                Log::info('Message Length:',[strlen($data_string)]);

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

                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

                $resultCurlPost = curl_exec($ch);
                curl_close($ch);

                Log::info('Response Data', explode('---', $resultCurlPost));
                if(!empty($resultCurlPost)){
                    Log::info("Response Data Length:\n",[strlen($resultCurlPost)]);

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
                }
                else
                {  Log::info("No result Returned"."\n");}

            }
            else
            { Log::info("Error: Unable to read the cert store.\n"); exit;}
        }

    }


}
