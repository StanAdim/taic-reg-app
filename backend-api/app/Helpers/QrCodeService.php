<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    protected $qr_codePath;
    
    public function __construct(){
        $this->qr_codePath = 'QR/Forums/';
    }

    public function generateQrCode($data)
    {
       // Path to the logo
       $logoPath = public_path('/images/nembo.png');

       // Generate the QR code with a logo
    //    $qr_json = [
    //        "opType"=>"2",
    //        "shortCode"=>"001001",
    //        "billReference"=>$bill_data->reference_no,
    //        "amount"=>$bill_data->amount,
    //        "billCcy"=>$bill_data->ccy,
    //        "billExprDt"=>$bill_data->bill_exp,
    //        "billPayOpt"=>$bill_data->bill_pay_opt,
    //        "billRsv01"=>"",
    //    ];
       $qrData = json_encode($data);

       $qrCode = QrCode::size(100)
                       ->merge($logoPath, 0.3, true) // 0.3 indicates 30% of the QR code size, adjust as needed
                       ->generate($qrData ?? 0);
        return $qrCode;
    }
}

