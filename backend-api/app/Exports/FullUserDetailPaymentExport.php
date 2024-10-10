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
        // Eager load userInfo, nation, region, and bills, and filter users with bills that have status = 1
        return User::whereHas('bills', function($query) {
            $query->where('status', 1); // Only include users with bills where status = 1
        })->with(['userInfo.nation', 'userInfo.region', 'bills'])->get();
    }

    // Define the headings for the Excel file
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone Number',
            'Country',
            'Region',
            'Address',
            'Institution',
            'Position',
            'Paid Amount',
        ];
    }

    // Map each user's data to the corresponding row
    public function map($user): array
    {
        // Get the first bill's paid_amt where status = 1
        $firstBillPaidAmt = $user->bills->where('status', 1)->first() ? $user->bills->where('status', 1)->first()->paid_amt : 'N/A';

        return [
            $user->firstName.' '.$user->middleName.' '.$user->lastName,
            $user->email,
            $user->userInfo ? $user->userInfo->phoneNumber : 'N/A',  // Get phone number from UserInfo
            $user->userInfo && $user->userInfo->nation ? $user->userInfo->nation->name : 'N/A',  // Get country name from Nation model
            $user->userInfo && $user->userInfo->region ? $user->userInfo->region->name : 'N/A',  // Get region name from Region model
            $user->userInfo ? $user->userInfo->address : 'N/A',  // Get address from UserInfo
            $user->userInfo ? $user->userInfo->institution : 'N/A',  // Get institution from UserInfo
            $user->userInfo ? $user->userInfo->position : 'N/A',  // Get position from UserInfo
            $firstBillPaidAmt,  // Get the paid amount of the first bill with status = 1
        ];
    }
}
