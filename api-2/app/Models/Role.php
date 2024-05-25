<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = ['name'];
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    public function users(){
        return $this->hasMany(User::class);
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')->withTimestamps();
    }
}

