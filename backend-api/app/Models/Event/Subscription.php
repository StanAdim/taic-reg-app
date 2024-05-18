<?php

namespace App\Models\Event;

use App\Models\Taic\Conference;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory ;


    protected $fillable = ['user_id', 'conference_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }}
