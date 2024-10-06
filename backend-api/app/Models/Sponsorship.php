<?php

namespace App\Models;

use App\Models\Taic\Conference;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "name",
        "category",
        "sub_category",
        "conference_id",
        "imageFileName",
        'is_visible'
    ];
    public function conference()
    {
        return $this->belongsTo(Conference::class,'conference_id');
    }
}
