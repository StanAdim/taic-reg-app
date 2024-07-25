<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('data/prof_25_07.json'));
        $data = json_decode($json, true);
        foreach ($data as $item) {
            DB::table('professionals')->insert([
                "DateOfRegistration" => $item['DateOfRegistration'],
                "RegNo" => $item['RegNo'],
                "Name" => $item['Name'],
                "Employer" => $item['Employer'],
                "ProfessionalCategory" => $item['ProfessionalCategory'],
                "AreaOfSpecialization" => $item['AreaOfSpecialization'],
                "Email" => $item['Email'],
                "Mobile" => $item['Mobile'],
                "Gender" => $item['Gender'],
                "Region" => $item['Region'],
            ]);
        }
        }
}
