<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayBill extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        'description',
        'user_id',
        'phone_number',
        'customer_name',
        'customer_email',
        'approved_by',
        'amount',
        'ccy',
        'payment_option',
        'status_code',
        'expires_at',
        'payment_order_id',
        'callback_url',
    ];

    protected $dates = ['expires_at']; // Ensure 'expires_at' is treated as a date

}
