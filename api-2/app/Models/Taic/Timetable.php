<?php

namespace App\Models\Taic;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory; use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "startTime",
        "endTime",
        "status",
        "day_id",
        'is_visible'
    ];
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }
}
