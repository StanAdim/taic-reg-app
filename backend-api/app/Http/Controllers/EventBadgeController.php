<?php

namespace App\Http\Controllers;

use App\Helpers\QrCodeService;
use App\Models\EventBadge;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendBadgeMail;

class EventBadgeController extends Controller
{
    protected $qrCodeService;
    protected $qr_codePath;

    public function __construct(QrCodeService $qrCodeService){
        $this->qrCodeService = $qrCodeService;
        $this->qr_codePath = 'QR/images/';

    }

    public function sendBadgeToParticipant()
    {
        // Retrieve participant data from the request (or from your database)
        $currentYear = date("Y");
        $firstName = 'Nsajigwa';
        $middle = 'Mwakalimile';
        $lastName = 'Mwaibalegambo';
        $company = 'ICT COMMISSION';
        $conference_name = 'Tanzania Annual ICT Conference';
        $email = 'stanjustine@gmail.com';
        $LogoImage = env('APP_URL')."/images/logo.jpeg";

        $QRimage = env('APP_URL')."/GeneratedQrCodes/".$firstName.".png";
        $qrCode = $this->qrCodeService->generateQrCode([$middle,$firstName,$lastName,$company]);
        // Generate the PDF
        $pdf = Pdf::loadView('mail.reports.badgeCard', 
        compact('firstName', 'LogoImage','lastName', 'middle', 'company', 'conference_name', 'qrCode', 'currentYear'));
        return $pdf->download($lastName.'-'.time().'-card.pdf');


        // Send email with the PDF attachment
        // Mail::to($email)->send(new SendBadgeMail($pdf->output()));

        return view('mail.reports.badgeCard', 
        compact('firstName', 'lastName', 'middle', 'company', 'conference_name', 'LogoImage', 'qrCode', 'currentYear'));

        // return response()->json(['message' => 'Badge sent successfully!']);
    }
}
