<?php

namespace App\Imports;

use App\Models\Professional;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProfessionalImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Professional([
            'DateOfRegistration'     => $row['dateofregistration'],
            'RegNo'                  => $row['regno'],
            'Name'                   => $row['name'],
            'Employer'               => $row['employer'],
            'ProfessionalCategory'    => $row['professionalcategory'],
            'AreaOfSpecialization'    => $row['areaofspecialization'],
            'Email'                  => $row['email'],
            'Mobile'                 => $row['mobile'],
            'Gender'                 => $row['gender'],
            'Region'                 => $row['region'],
        ]);
    }
}
