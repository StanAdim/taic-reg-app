<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Event\Subscription;
use App\Models\Taic\Conference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'email',
        'role_id',
        'hasInfo',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function events()
    {
        return $this->belongsToMany(Conference::class, 'subscriptions');
    }
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function bills()
{
    return $this->hasMany(Bill::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}
}
