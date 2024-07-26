<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory, HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = [
        "phoneNumber",
        "user_id",
        "professionalStatus",
        "professionalNumber",
        "institution",
        "position",
        "address",
        "region_id",
        "district_id",
        "notificationConsent",
        "nation",
       
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
