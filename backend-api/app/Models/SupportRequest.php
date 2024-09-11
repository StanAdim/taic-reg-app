<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'subject', 'message', 'status'];

    public function responses()
    {
        return $this->hasMany(SupportResponse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
