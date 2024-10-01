<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements  FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  User::join(
            'user_infos', 'users.id', '=', 'user_infos.user_id')
        ->select(
            "users.firstName", 
            "users.middleName",
            "users.lastName", 
            "users.email",
            "user_infos.phoneNumber", // Example additional field
            "user_infos.institution",       // Example additional field
            "user_infos.position",     // Example additional field
            // "user_infos.nation",     // Example additional field
        )
        ->get();
    }
    public function headings(): array
    {
        return [
            "FIRST NAME", 
            "MIDDLE NAME", 
            "LAST NAME", 
            "EMAIL", 
            "PHONE NUMBER",  // Additional heading
            "INSTITUTION" ,      // Additional heading
            "POSITION" ,      // Additional heading
            // "NATION" ,      // Additional heading
        ];
    }   
}
