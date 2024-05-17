<?php

namespace App\Models\Taic;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "name",
        "email",
        "designation",
        "institution",
        "linkedinLink",
        "twitterLink",
        "isMain",
        "conference_id",
        "imgPath",
        'is_visible'
    ];
    public function conference()
    {
        return $this->belongsTo(Conference::class,'conference_id');
    }
}
