<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class XmlRequestHelper
{
    public static function GepgSubmissionRequest($billingData){
        $fileKeyPass = env('GEPG_KEYPASS');
        $collectionCenCode = env('GEPG_COLLECTIONCENCODE');
        $Gsfcode = env('GEPG_GSFCODE');
        $SubSpCode = env('GEPG_SUBSPCODE');
        //Function to get Data string

        $bill_exp = Carbon::now()->addMonths(10)->format('Y-m-d\TH:i:s');
        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate_2.pfx")) {
            Log::info(["\n\n --------Error: \n *** Unable to read the cert file\n"]);
            exit;
        }
        else
        {
            $id = $billingData->id;
            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass)){
                //Bill Request
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
                                <BillDesc>".htmlspecialchars($billingData->name,ENT_XML1, 'UTF-8')."</BillDesc>
                                <CustTin>111111111</CustTin>
                                <CustId>".$billingData->user_id."</CustId>
                                <CustIdTyp>5</CustIdTyp>
                                <CustAccnt>".GeneralCustomHelper::formatThePhoneNumber($billingData->phone_number)."</CustAccnt>
                                <CustName>".htmlspecialchars($billingData->customer_name,ENT_XML1, 'UTF-8')."</CustName>
                                <CustCellNum>".GeneralCustomHelper::formatThePhoneNumber($billingData->phone_number)."</CustCellNum>
                                <CustEmail>".$billingData->email."</CustEmail>
                                <BillGenDt>".$genDate."</BillGenDt>
                                <BillExprDt>".$bill_exp."</BillExprDt>
                                <BillGenBy>".htmlspecialchars($billingData->billApproveBy,ENT_XML1, 'UTF-8')."</BillGenBy>
                                <BillApprBy>".htmlspecialchars($billingData->billApproveBy,ENT_XML1, 'UTF-8')."</BillApprBy>
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
                $requestUri = env('GEPG_SUBMISSIONURI');
                $signedPayload = "<Gepg>".$content."<signature>".$signature."</signature></Gepg>";
                //Perform Curl to a Gepg
                Log::info("-----START SUBMISSION FOR BILL-----\n");
                Log::info("### BILL ID:", ['Bill ID' => $id]);

                Log::info("###  BILL SUB REQ ID:",['Sub Req ID'=> $reqID]);
                // Log::info("###  BILL SUB REQ:",['Sub Req'=> $content]);
                $resultCurlPost = GeneralCustomHelper::performCurlSignedPayload($signedPayload,$requestUri);
                if(!empty($resultCurlPost)){
                    Log::info("### BILL SUB RES CODE:",['Code' => GeneralCustomHelper::get_string_between($resultCurlPost, '<AckStsCode>', '</AckStsCode>')]);
                    Log::info("### BILL SUB RES DESC:",['Description' => GeneralCustomHelper::get_string_between($resultCurlPost, '<AckStsDesc>', '</AckStsDesc>')]);
                    Log::info("----END SUBMISSION RESPONSE----");

                    $vdata = GeneralCustomHelper::get_string_between($resultCurlPost, '<Gepg>', '<signature>');
                    $vsignature = GeneralCustomHelper::get_string_between($resultCurlPost, '<signature>', '</signature>');
    
                    //Sign return contents
                    return GeneralCustomHelper::isVerifyPayload($vdata, $vsignature);

                }
                else{ Log::info("No result Returned"."\n");}
            }
            else
            { Log::info("\n\n------Error: Unable to read the cert store.\n"); exit;}
        }

    }

    public static function GepgReconciliationRequest($reconsileDate){
        $fileKeyPass = env('GEPG_KEYPASS');
        //Function to get Data string
        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate_2.pfx")) {
            Log::info(["--------Error: \n *** Unable to read the cert file\n"]);
            exit;
        }
        else
        {
            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass)){
                //Bill Request
                $systemid =env('GEPG_SYSTEMID');
                $SpGrpCode =env('GEPG_SPGRPCODE');
                $reqID = GeneralCustomHelper::generateReqID(16);

                $content ="<sucSpPmtReq>
                                <ReqId>".$reqID."</ReqId>
                                <SpGrpCode>".$SpGrpCode."</SpGrpCode>
                                <SysCode>".$systemid."</SysCode>
                                <TrxDt>".$reconsileDate."</TrxDt>
                                <Rsv1/>
                                <Rsv2/>
                                <Rsv3/>
                            </sucSpPmtReq>";
                //create signature
                openssl_sign($content, $signature, $cert_info['pkey'], "sha256WithRSAEncryption");
                //output crypted data base64 encoded
                $signature = base64_encode($signature);
                //Combine signature and content signed
                $requestUri = env('GEPG_RECONCILIATION_URI');
                $signedPayload = "<Gepg>".$content."<signature>".$signature."</signature></Gepg>";
                //Perform Curl to a Gepg
                
                Log::info("----- RECONCILIATION REQUEST START-----");
                $resultCurlPost = GeneralCustomHelper::performCurlSignedPayload($signedPayload,$requestUri);
                Log::info("### RECON REQ ID:", ['Request ID'=>$reqID]);
                
                if(!empty($resultCurlPost)){
                    Log::info("### ACK RECON CODE:",
                    [ 'Recon Ack Code' => GeneralCustomHelper::get_string_between($resultCurlPost, '<AckStsCode>', '</AckStsCode>')]);
                    Log::info("### ACK  RECON DESC:",
                    [ 'Recon Ack Desc' => GeneralCustomHelper::get_string_between($resultCurlPost, '<AckStsDesc>', '</AckStsDesc>')]);
                    // Log::info("----- ACK:###",[$resultCurlPost]);
                    $vdata = GeneralCustomHelper::get_string_between($resultCurlPost, '<Gepg>', '<signature>');
                    $vsignature = GeneralCustomHelper::get_string_between($resultCurlPost, '<signature>', '</signature>');
                    //Verify Signed Data
                    return GeneralCustomHelper::isVerifyPayload($vdata, $vsignature);
                }
                else{ Log::info("No result Returned"."\n");}
            }
            else
            { Log::info("Error: Unable to read the cert store.\n"); exit;}
        }
        Log::info("----- END RECONCILLIATIONS REQUEST  -------\n");

    }

    public static function GepgCancellationRequest($billingData, $cancelledBy, $reason = "Customer over bill"){
        $fileKeyPass = env('GEPG_KEYPASS');
        //Function to get Data string

        if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivate_2.pfx")) {
            Log::info(["-------- Error: *** Unable to read the cert file\n"]);
            exit;
        }
        else {

            if (openssl_pkcs12_read($cert_store, $cert_info, $fileKeyPass)){
                //Bill Request
                $systemid =env('GEPG_SYSTEMID');
                $spGrpCode = env('GEPG_SPGRPCODE') ;
                $reqID = GeneralCustomHelper::generateReqID(16);
                $content ="<billCanclReq>
                                <ReqId>".$reqID."</ReqId>
                                <SpGrpCode>".$spGrpCode."</SpGrpCode>
                                <SysCode>".$systemid."</SysCode>
                                <BillTyp>1</BillTyp>
                                <GrpBillId>".$billingData->id."</GrpBillId>
                                <CanclGenBy>".$cancelledBy->firstName." ".$cancelledBy->lastName."</CanclGenBy>
                                <CanclApprBy>".$cancelledBy->firstName." ".$cancelledBy->lastName."</CanclApprBy>
                                <CanclReasn>".$reason."</CanclReasn>
                            </billCanclReq>";

                //create signature
                openssl_sign($content, $signature, $cert_info['pkey'], "sha256WithRSAEncryption");
                //output crypted data base64 encoded
                $signature = base64_encode($signature);
                //Combine signature and content signed
                $requestUri = env('GEPG_CANCELLATION_URI');
                $signedPayload = "<Gepg>".$content."<signature>".$signature."</signature></Gepg>";
                //Perform Curl to a Gepg
                Log::info("--------- GEPG CANCELLATION START -------");
                $resultCurlPost = GeneralCustomHelper::performCurlSignedPayload($signedPayload,$requestUri);
                
                if(!empty($resultCurlPost)){
                    Log::info("### CANC REQ ID::",["ID req" => $reqID]);
                    Log::info("### CANC CODE::",['Cance ack code' =>  GeneralCustomHelper::get_string_between($resultCurlPost, '<CanclStsCode>', '</CanclStsCode>')]);
                    Log::info("### CANC DESC::",['Cance ack desc' =>  GeneralCustomHelper::get_string_between($resultCurlPost, '<CanclStsDesc>', '</CanclStsDesc>')]);
                    $vdata = GeneralCustomHelper::get_string_between($resultCurlPost, '<Gepg>', '<signature>');
                    $vsignature = GeneralCustomHelper::get_string_between($resultCurlPost, '<signature>', '</signature>');
                    
                    //Verify Data using Certifites
                    Log::info("---------GEPG CANCELLATION END -------");
                    return GeneralCustomHelper::isVerifyPayload($vdata, $vsignature);
                }
                else{ Log::info("No result Returned"."\n");}
            }
            else
            { Log::info("Error: Unable to read the cert store.\n"); exit;}
        }

    }


}
