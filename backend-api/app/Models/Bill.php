<?php

namespace App\Models;

use App\Models\Taic\Conference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'conference_id', 'event_fee', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Conference::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
