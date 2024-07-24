<?php
if (!$cert_store = file_get_contents("gepgclientprivate.pfx")) {
    echo "Error: Unable to read the cert file\n";
    exit;
}
else
{
	if (openssl_pkcs12_read($cert_store, $cert_info, "passpass"))   
	{
	 
	//Bill Request 
	 $id = round(microtime(true) * 1000); 	 
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
			$serverIp = "https://uat1.gepg.go.tz";
			$uri = "/api/bill/20/submission";
			

			$data_string = $data;
			echo "Message details"."\n".$data_string."\n";
			echo "\n";
			echo "Request Lenght:\n";
			echo strlen($data_string);
			echo "\n";

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
			
			if(!empty($resultCurlPost)){

				echo "Received Response\n";
				print_r($resultCurlPost);
				echo "\n";
				echo "Response Length:\n";
				echo strlen($resultCurlPost);			
				
				//Tags used in substring response content
				$datatag = "billSubReqAck";
				$sigtag = "signature";
				
				//Get data and signature from response
				$vdata = getDataString($resultCurlPost,$datatag);
				$vsignature = getSignatureString($resultCurlPost,$sigtag);
				
				echo "\n";
				echo "Data Received:\n";
				echo $vdata;
				echo "\n";
				echo "Data Length:\n";
				echo strlen($vdata);
				echo "\n";
				echo "Signature Received:\n";
				//echo $vsignature;
				echo "\n";

				//Get Certificate contents
				if (!$pcert_store = file_get_contents("gepgpubliccertificate.pfx")) {
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
			else
			{
				echo "No result Returned"."\n";
			}
			
		} 
	else
	{

    echo "Error: Unable to read the cert store.\n";
    exit;
	}

}
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

 
?>



