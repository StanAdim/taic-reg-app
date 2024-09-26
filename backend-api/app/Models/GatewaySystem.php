<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
 

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
        'user_agent',
        'authorization_token',
        'base_url',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($newSystem ) {
            $newSystem ->code = 'SYS-' . Str::random(8); //code generation
        });
    }
}
