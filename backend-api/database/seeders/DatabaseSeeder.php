<?php

namespace Database\Seeders;

use App\District;
use App\Models\User;
use App\Region;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            DistrictSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ProfessionalSeeder::class,
            NationSeeder::class,
        ]);
    }
}
