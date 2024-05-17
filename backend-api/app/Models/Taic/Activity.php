<?php

namespace App\Models\Taic;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory; use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    protected $casts = ['panelist' => 'array',];
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "name",
        "hasMinActivity",
        "minActivity",
        "hasPanelist",
        "panelist", // array
        "moderator",
        "timetable_id",
        'is_visible'
    ];
    public function timetable()
    {
        return $this->belongsTo(Timetable::class,'timetable_id');
    }

}
