<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewaySystem extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'code',
        'description',
        'callback_controll_number',
        'callback_payment_number',
        'callback_reconcilliation',
        'callback_addition',
        'base_url',
    ];
}
