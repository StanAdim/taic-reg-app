<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class XmlResponseHelper
{
    
    public static function handleResponse($request)
    {
        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
        function getXMLData($request)
        {
            $values = array();
            $values['billid'] = get_string_between($request, '<BillId>', '</BillId>');
            $values['PayCntrNum'] = get_string_between($request, '<PayCntrNum>', '</PayCntrNum>');
            $values['TrxSts'] = get_string_between($request, '<TrxSts>', '</TrxSts>');
            $values['TrxStsCode'] = get_string_between($request, '<TrxStsCode>', '</TrxStsCode>');

            return $values;
        }
       
        Log::info("================== CALL BACK RESPONSE FROM GEPG====================");
        Log::info($request->getContent());
        Log::info("================== CALL BACK RESPONSE FROM GEPG====================");
        // Received Data
        $xmlData = $request->getContent();
       // Parse the XML data
       try {
        $xml = simplexml_load_string($xmlData, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        Log::info("\n Response : \n ############### ");

        Log::info("Response: \n ############### ");
        
        Log::info("\n ############### End Response : \n");
        // Extract relevant data from parsed array
        $billTrxInf = $array['billSubRes'];
        return $array["billSubRes"]['BillHdr']["ResStsCode"];
        $billId = $billTrxInf['BillId'];
        $trxSts = $billTrxInf['TrxSts'];
        $payCntrNum = $billTrxInf['PayCntrNum'];
        $trxStsCode = $billTrxInf['TrxStsCode'];

        

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid XML data',
            'error' => $e->getMessage()
        ], 400);
    }

        // Assuming you want to return a response to the external service
        return response()->json(['status' => 'success'], 200);
    

    }


}
