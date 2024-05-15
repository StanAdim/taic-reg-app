<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('data/Districts.json'));
        $data = json_decode($json, true);
        foreach ($data as $region) {
            DB::table('districts')->insert([
                'region' => $region['region'],
                'district' => $region['district'],
            ]);
        }    }
}
