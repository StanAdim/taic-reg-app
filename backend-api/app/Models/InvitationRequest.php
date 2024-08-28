<?php

namespace App\Models;

use App\Models\Taic\Conference;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationRequest extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string'; // UUIDs are stored as strings
    public $incrementing = false;  // Disable auto-increment for the primary key

    protected $fillable = [
        'user_id',
        'conference_id',
        'institutionName',
        'po_box',
        'region_Id',
        'addressingTo',
        'hostPosition',
        'status',
        'email_to',
        'cc_To',  // JSON field
        'others',  // JSON field
    ];

    // Define relationships if necessary
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
