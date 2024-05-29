<?php

namespace App\Models\Taic;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event\Subscription;
use App\Models\User;

class Gathering extends Model
{
    use HasFactory;
    use HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "title",
        "year",
        "startDate",
        "endDate",
        "venue",
        "theme",
        "category_id",
        "aboutGathering",
        "hasEntranceFee",
        "defaultFee",
        "foreignerFee",
        "guestFee",
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
