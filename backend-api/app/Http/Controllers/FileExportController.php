<?php

namespace App\Http\Controllers;

use App\Exports\BillsExport;
use App\Exports\ParticipantsExport;
use App\Exports\PaymentExport;
use App\Exports\UsersExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class FileExportController extends Controller
{
    //
    public function exportUsers() {
        $filePath = 'documents/excels/users.xlsx';
        Excel::store(new UsersExport, $filePath);
        return response() ->json(['path' => $filePath]);
    }
    public function exportParticipants() {
        return Excel::download(new ParticipantsExport, 'event_participants.xlsx');
    }
    public function exportBills() {
        return Excel::download(new BillsExport, 'all_bills_ems.xlsx');
    }
    public function exportPayments() {
        return Excel::download(new PaymentExport, 'event_payments.xlsx');
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
    public function downloadFile(Request $request)
    {
        // return $request 
        $file_name = $request->name;
        if ($file_name == null) {
            abort(404);
        }

        if (!Storage::disk('local')->exists($file_name)) {
            abort(404);
        }
        $pdfPath = storage_path('app/'. $file_name);
        return response()->file($pdfPath);
    }
}
