<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendeeRole = Role::where('name', 'attendee')->first();
        $AdminRole = Role::where('name', 'admin')->first();
        $accountantRole = Role::where('name', 'accountant')->first();
        $promotorRole = Role::where('name', 'promotor')->first();
        User::create([
            'firstName' => 'Attendee',
            'middleName' => '',
            'lastName' => 'Test',
            'role_id' => $attendeeRole->id,
            'email' => 'attendee@example.com',
            'password'=> bcrypt('password'),
            'email_verified_at'=> "1122333"
        ]);
        User::create([
            'firstName' => 'Admin',
            'middleName' => '',
            'lastName' => 'Test',
            'role_id' => $AdminRole->id,
            'email' => 'admin@example.com',
            'password'=> bcrypt('password'),
            'email_verified_at'=> '1122333'
        ]);
        User::create([
            'firstName' => 'Accountant',
            'middleName' => '',
            'lastName' => 'Test',
            'role_id' => $accountantRole->id,
            'email' => 'accountant@example.com',
            'password'=> bcrypt('password'),
            'email_verified_at'=> '1122333'
        ]);
        User::create([
            'firstName' => 'Promotor ',
            'middleName' => '',
            'lastName' => 'Test',
            'role_id' => $promotorRole->id,
            'email' => 'promotor@example.com',
            'password'=> bcrypt('password'),
            'email_verified_at'=> '1122333'
        ]);
    }
}
