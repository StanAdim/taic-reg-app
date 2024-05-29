<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


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
            'firstName' => 'Stanley',
            'middleName' => 'Justine',
            'lastName' => 'Mahenge',
            'role_id' => $attendeeRole->id,
            'email' => 'stanjustine@gmail.com',
            'password'=> bcrypt('passpass'),
            'verificationKey' => strtolower(Str::random(32)),

        ]);
        User::create([
            'firstName' => 'Admin',
            'middleName' => 'User',
            'lastName' => 'ICTC',
            'role_id' => $AdminRole->id,
            'email' => 'ictsupport@ictc.go.tz',
            'password'=> bcrypt('passpass'),
            'verificationKey' => strtolower(Str::random(32)),

        ]);
        User::create([
            'firstName' => 'Accountant',
            'middleName' => 'User',
            'lastName' => 'Accounts',
            'role_id' => $accountantRole->id,
            'email' => 'accountant@example.com',
            'password'=> bcrypt('password'),
            'email_verified_at'=> now(),
            'verificationKey' => strtolower(Str::random(32)),

        ]);
        User::create([
            'firstName' => 'Info ',
            'middleName' => 'Event',
            'lastName' => 'Organiser',
            'role_id' => $promotorRole->id,
            'email' => 'info@ictc.go.tz',
            'password'=> bcrypt('passpass'),
            'email_verified_at'=>now(),
            'verificationKey' => strtolower(Str::random(32)),

        ]);
    }
}
