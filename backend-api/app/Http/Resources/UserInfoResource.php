<?php

namespace App\Http\Resources;

use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "phoneNumber" => $this->phoneNumber,
            "professionalStatus" => $this->professionalStatus,
            "professionalNumber" => $this->professionalNumber,
            "institution" => $this->institution,
            "position" => $this->position,
            "region" => RegionResource::collection(Region::where('id',$this->region_id)->get())->first(),
            "district" => DistrictResource::collection(District::where('id',$this->district_id)->get())->first(),
        ];
    }
}
