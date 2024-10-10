<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FullUserDetailPaymentExport implements FromCollection, WithHeadings, WithMapping {
    // This method retrieves the collection of users with their info and bills where at least one bill has status = 1
    public function collection()
    {
        // Eager load userInfo and bills, and filter users with bills that have status = 1
        return User::whereHas('bills', function($query) {
            $query->where('status', 1); // Only include users with bills where status = 1
        })->with(['userInfo', 'bills'])->get();
    }

    // Define the headings for the Excel file
    public function headings(): array
    {
        return [
            // 'ID',
            'Name',
            'Email',
            'phoneNumber', // Add other relevant userInfo fields
            'Region', // Add other relevant userInfo fields
            'Instititon', // Add other relevant userInfo fields
            'Position', // Add other relevant userInfo fields
            'Paid Amount', // Add other relevant bill fields
        ];
    }

    // Map each user's data to the corresponding row
    public function map($user): array
    {
        // Get the first bill's paid_amt where status = 1
        $firstBillPaidAmt = $user->bills->where('status', 1)->first() ? $user->bills->where('status', 1)->first()->paid_amt : 'N/A';

        return [
            // $user->id,
            $user->firstName.' '.$user->middleName.' '.$user->lastName,
            $user->email,
            $user->userInfo ? $user->userInfo->phoneNumber : 'N/A',  // Customize this with userInfo fields
            $user->userInfo ? $user->userInfo->region_id : 'N/A',  // Customize this with userInfo fields
            $user->userInfo ? $user->userInfo->district_id : 'N/A',  // Customize this with userInfo fields
            $user->userInfo ? $user->userInfo->institution : 'N/A',  // Customize this with userInfo fields
            $user->userInfo ? $user->userInfo->position : 'N/A',  // Customize this with userInfo fields
            $firstBillPaidAmt,  // Customize this with bill fields
        ];
    }
}
