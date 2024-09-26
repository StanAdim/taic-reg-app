<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class FileExportController extends Controller
{
    //
    public function exportUsers() {
        $fileName = 'users.xlsx';
        $filePath = public_path('documents/excels/' . $fileName);
        // Excel::store(new UsersExport, $filePath);
        return response()->download($filePath);
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportBills() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportPayments() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function exportParticipationCertificate() {
        return view('pdf.participation_certificate');
    }
    public function printCertificate(){
        $slug = 'STANLEY JUSTINE MAHENGE';
        $eventDate = "04th - 05th April 2024";
        $venue = "Gran Melia - Arusha";
        $eventName = '3rd Tanzania Cybersecurity Forum';
        $pdf =Pdf::loadView('pdf.participation_certificate',
        [   'venue' => $venue,
            'eventDate' => $eventDate,
            'eventName' => $eventName,
            'participantName' => $slug])
         ->setPaper('a4', 'landscape');
        return $pdf->download($slug."-TAIC-PARTICIPATION-CERTIFICATE".'.pdf');
    }
}
