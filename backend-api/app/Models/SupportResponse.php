<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportResponse extends Model
{
    use HasFactory;
    protected $fillable = ['support_request_id', 'user_id', 'response'];

    public function request()
    {
        return $this->belongsTo(SupportRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
