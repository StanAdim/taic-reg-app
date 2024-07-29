<?php

namespace App\Models;

use App\Models\Taic\Conference;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentMaterial extends Model
{
    use HasFactory,HasUuids;
    protected $fillable =[
        'name',
        'file_name',
        'path',
        'conference_id',
        'user_id',
        'status',
    ];
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
