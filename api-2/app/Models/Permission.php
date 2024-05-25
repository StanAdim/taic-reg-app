<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory,HasUuids;
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing
    protected $fillable = ['name','code'];
    public function role(){
        return $this->belongsToMany(Role::class, 'role_permission', 'role_id', 'permission_id')
                            ->withTimestamps();
    }
}
