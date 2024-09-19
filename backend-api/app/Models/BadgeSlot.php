<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeSlot extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'event_badge_id',
        'tag',
        'status',
    ];
}
