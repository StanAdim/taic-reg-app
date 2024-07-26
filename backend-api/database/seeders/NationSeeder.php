<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('data/countries.json'));
        $data = json_decode($json, true);
        foreach ($data as $item) {
            DB::table('nations')->insert([
                'name' => $item['name'],
                'code' => $item['code'],
            ]);
        }
  
        }
}
