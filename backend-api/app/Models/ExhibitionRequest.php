<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitionRequest extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'number' ,
        'companyEmail',
        'companyName',
        'message',
        'status',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
