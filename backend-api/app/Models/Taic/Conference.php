<?php

namespace App\Models\Taic;

use App\Models\Event\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "name",
        "conferenceYear",
        "startDate",
        "endDate",
        "venue",
        "theme",
        "aboutConference",
        "defaultFee",
        "foreignerFee",
        "guestFee",
        "status",
        "lock"
    ];
    public function speakers()
    {
        return $this->hasMany(Speaker::class);
    }
    public function days()
    {
        return $this->hasMany(Day::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subscriptions');
    }
}
