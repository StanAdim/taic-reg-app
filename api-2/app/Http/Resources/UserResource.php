<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'firstName'=> $this->firstName,
            'lastName'=> $this->lastName,
            'middleName'=> $this->middleName,
            'email'=> $this->email,
            'userName'=> $this->firstName.' '. $this->middleName. ' '. $this->lastName,
            'role'=> $this->role->name,
            'registrationDate'=> Carbon::parse($this->created_at)->format('M j, Y'),
        ];
    }
}
