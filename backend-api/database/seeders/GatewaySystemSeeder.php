<?php

namespace Database\Seeders;

use App\Models\GatewaySystem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class GatewaySystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GatewaySystem::create([
            'name' => 'ICT EMS',
            'description' => 'registration for events',
            'callback_controll_number' => '/api/billing/update-control-number/',
            'callback_payment_number' => '/api/billing/update-payment-status/',
            'callback_reconcilliation' => '/sample',
            'callback_addition' => 'sample',
            'base_url' => 'https://rhino-present-firmly.ngrok-free.app',
            'code' => Str::random(8),
        ]);
    }
}
