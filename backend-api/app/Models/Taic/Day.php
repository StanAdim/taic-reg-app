<?php

namespace App\Models\Taic;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory; use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "date",
        "label",
        "status",
        "conference_id",
        'is_visible'
    ];
    public function conference()
    {
        return $this->belongsTo(Conference::class, 'conference_id');
    }
    public function timetables()
    {
        return $this->hasMany(Timetable::class,);
    }
}
