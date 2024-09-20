<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class FileExportController extends Controller
{
    //
    public function exportUsers() {
        $fileName = 'users.xlsx';
        $filePath = public_path('documents/excels/' . $fileName);
        Excel::store(new UsersExport, $filePath);
        // return response()->download($filePath);
        // return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function exportBills() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    
    public function exportPayments() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
