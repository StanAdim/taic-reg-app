<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;
    protected $fillable = [
        "DateOfRegistration",
        "RegNo",
        "Name",
        "Employer",
        "ProfessionalCategory",
        "AreaOfSpecialization",
        "Email",
        "Mobile",
        "Gender",
        "Region",
        "isVerified",
    ];
}
