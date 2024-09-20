<?php

namespace App\Imports;

use App\Models\Professional;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;


class ProfessionalImport implements ToModel, WithHeadingRow
{

    public function model(array $row){
        try {
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
         } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                Log::warning('Duplicate RegNo found: ' . $row['regno']);
                return null;
            }
            throw $e;
        }
    }

}
