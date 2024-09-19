<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionaListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=> $this->Name,
            'phoneNumber'=> $this->Mobile,
            'RegNo'=> $this->RegNo,
            'Email'=> $this->Email,
            'isVerified'=> $this->isVerified,
            'DateOfRegistration'=> $this->DateOfRegistration,
            'ProfessionalCategory'=> $this->ProfessionalCategory,
            'Employer'=> $this->Employer,
        ];   
    }
}
