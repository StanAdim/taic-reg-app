<?php

if (!$cert_store = file_get_contents(__DIR__."/gepgclientprivatekey.pfx")) {
            echo "Error: Unable to read the cert file\n";
            exit;
        }
        else {
        if (openssl_pkcs12_read($cert_store, $cert_info, "passpass")){
        //Bill Request
        $id = round(microtime(true) * 1000);
        $spcode ="SP19912";
        $systemid ="TICTC001";
        // $content ='<billSubReq><BillHdr><ReqId>1321307376409088</ReqId><SpCode>'.$spcode.'</SpCode><SysCode>'.$systemid.'</SysCode><BillTyp>1</BillTyp><PayTyp>2</PayTyp><GrpBillId>'.$id.'</GrpBillId></BillHdr><BillDtls><BillDtl><BillId>'.$id.'</BillId><SpCode>'.$spcode.'</SpCode><CollCentCode>HQ</CollCentCode><BillDesc>certificateinvoice</BillDesc><CustTin>111111111</CustTin><CustId>111111111</CustId><CustIdTyp>4</CustIdTyp><CustAccnt>255657871769</CustAccnt><CustName>maasaifurniture</CustName><CustCellNum>255657871769</CustCellNum><CustEmail>maasai@gmail.com</CustEmail><BillGenDt>2024-02-08T10:13:29</BillGenDt><BillExprDt>2024-02-22T10:13:29</BillExprDt><BillGenBy>maasaifurniture</BillGenBy><BillApprBy>maasaifurniture</BillApprBy><BillAmt>100000.00</BillAmt><BillEqvAmt>100000.00</BillEqvAmt><MinPayAmt>100000.00</MinPayAmt><Ccy>TZS</Ccy><ExchRate>1.0</ExchRate><BillPayOpt>1</BillPayOpt><PayPlan>1</PayPlan><PayLimTyp>1</PayLimTyp><PayLimAmt>0.00</PayLimAmt><CollPsp/><BillItems><BillItem><RefBillId>'.$id.'</RefBillId><SubSpCode>1001</SubSpCode><GfsCode>140101</GfsCode><BillItemRef>'.$id.'</BillItemRef><UseItemRefOnPay>N</UseItemRefOnPay><BillItemAmt>100000.00</BillItemAmt><BillItemEqvAmt>100000.00</BillItemEqvAmt><CollSp>SP19928</CollSp></BillItem></BillItems></BillDtl></BillDtls></billSubReq>';
        $content ='<gepgBillSubReq>
    <BillHdr>
        <SpCode>SP713</SpCode>
        <RtrRespFlg>true</RtrRespFlg>
    </BillHdr>
    <BillTrxInf>
        <BillId>EMS909090909091</BillId>
        <SubSpCode>1001</SubSpCode>
        <SpSysId>TTPC001</SpSysId>
        <BillAmt>10000.00</BillAmt>
        <MiscAmt>0.0</MiscAmt>
        <BillExprDt>2024-02-22T10:13:29</BillExprDt>
        <PyrId>230222F0004-D</PyrId>
        <PyrName>yyyy</PyrName>
        <BillDesc>uyuy</BillDesc>
        <BillGenDt>2024-02-08T10:13:29</BillGenDt>
        <BillGenBy>Billing System</BillGenBy>
        <BillApprBy>Billing System</BillApprBy>
        <PyrCellNum>0719018067</PyrCellNum>
        <PyrEmail>epayments@posta.co.tz</PyrEmail>
        <Ccy>TZS</Ccy>
        <BillEqvAmt>10000.00</BillEqvAmt>
        <RemFlag>true</RemFlag>
        <BillPayOpt>3</BillPayOpt>
        <BillItems>
            <BillItem>
                <BillItemRef>EMS909090909091</BillItemRef>
                <UseItemRefOnPay>N</UseItemRefOnPay>
                <BillItemAmt>10000.00</BillItemAmt>
                <BillItemEqvAmt>10000.00</BillItemEqvAmt>
                <BillItemMiscAmt>0.0</BillItemMiscAmt>
                <GfsCode>140345</GfsCode>
            </BillItem>
        </BillItems>
    </BillTrxInf>
</gepgBillSubReq>';
            
                //create signature
                openssl_sign($content, $signature, $cert_info['pkey'], "sha1WithRSAEncryption");

                //output crypted data base64 encoded
                $signature = base64_encode($signature);

                //Combine signature and content signed
                $data = '<Gepg>'.$content.'<gepgSignature>'.$signature.'</gepgSignature></Gepg>';

                $resultCurlPost = "";
                $serverIp = "https://uat1.gepg.go.tz";
                // $uri = "/api/bill/20/submission";
                $uri = "/api/bill/sigqrequest";

                // echo $data;

                // exit;

                $data_string = $data;

                $ch = curl_init($serverIp.$uri);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                    // 'Content-Type:application/xml',
                                    // 'Gepg-Com:default.sp.in',
                                    // 'Gepg-Code:'.$spcode,
                                    // // 'Gepg-Alg:00S2',
                                    // 'Content-Length:'.strlen($data_string)
                                    "Content-Type:application/xml",
                        "Gepg-Com:default.sp.in",
                        "Gepg-Code:SP713",
                        "Content-Length:".strlen($data_string)
                                    )
                );

                // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                curl_setopt($ch, CURLOPT_TIMEOUT, 50);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 50);

                $resultCurlPost = curl_exec($ch);
                curl_close($ch);

                print_r($resultCurlPost);
                exit;

                if(!empty($resultCurlPost)){

                    // echo "Received Response\n";
                    // print_r($resultCurlPost);
                    // echo "\n";
                    // echo "Response Length:\n";
                    // echo strlen($resultCurlPost);

                    //Tags used in substring response content
                    $datatag = "billSubReqAck";
                    $sigtag = "signature";

                    //Get data and signature from response
                    $vdata = getDataString($resultCurlPost,$datatag);
                    $vsignature = getSignatureString($resultCurlPost,$sigtag);

                    // echo "\n";
                    // echo "Data Received:\n";
                    // echo $vdata;
                    // echo "\n";
                    // echo "Data Length:\n";
                    // echo strlen($vdata);
                    // echo "\n";
                    // echo "Signature Received:\n";
                    //echo $vsignature;
                    // echo "\n";

                    //Get Certificate contents
                    if (!$pcert_store = file_get_contents(__DIR__."/gepgpubliccertificate.pfx")) {
                        echo "Error: Unable to read the cert file\n";
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
                                echo "GOOD";
                            } elseif ($ok == 0) {
                                echo "Signature Status:";
                                echo "BAD";
                            } else {
                                echo "Signature Status:";
                                echo "UGLY, Error checking signature";
                            }
                        }
                    }
                }
                else{
                    echo "No result Returned"."\n";
                }
            }
        else
        {
        echo "Error: Unable to read the cert store.\n";
        exit;
        }

    }