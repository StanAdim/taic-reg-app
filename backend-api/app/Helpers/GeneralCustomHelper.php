<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GeneralCustomHelper{

    //random bill ID
    public static function generateReqID($length=16) {
        $randomNumberString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumberString .= mt_rand(0, 9);
        }
        return $randomNumberString;
    }
    // Get date from number of month
    public static function getGenerationDate($lastUntilNoMonth = 0) {
        $date = Carbon::now();
        $formattedDate = $date->addMonths($lastUntilNoMonth)->format('Y-m-d\TH:i:s');
        return $formattedDate;
    }
    // Get data between provided xml tag
    public static function get_string_between($xml_string, $tag_start, $tag_end){
        $xml_string = ' ' . $xml_string;
        $ini = strpos($xml_string, $tag_start);
        if ($ini == 0) return '';
        $ini += strlen($tag_start);
        $len = strpos($xml_string, $tag_end, $ini) - $ini;
        return substr($xml_string, $ini, $len);
    }
    // Check if the string starts with '+225'
     public static function formatThePhoneNumber($phoneNumber) {
        if (substr($phoneNumber, 0, 4) === '+225') {
            // Remove the '+' sign and return the rest of the string
            return '225' . substr($phoneNumber, 4);
        }
        // Return null if the string does not start with '+225'
        return 255738171742;
    }

    public static function performCurlSignedPayload($content, $requestUri){
        $GepgBaseUrl = env('GEPG_BASEURL');
        $resultCurlPost = "";
        $serverIp = $GepgBaseUrl;
        $uri = $requestUri;
        $data_string = $content;
        $spcode =env('GEPG_SPCODE');
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
     return $resultCurlPost;   
    }


}
