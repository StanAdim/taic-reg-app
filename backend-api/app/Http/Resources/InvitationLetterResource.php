<?php

namespace App\Http\Resources;

use App\Http\Resources\Taic\ConferenceResource;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvitationLetterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'institutionName' => $this -> institutionName,
            'conference' => $this -> conference->name,
            'user' =>  $this -> user -> firstName.' '. $this -> user -> middleName. ' '. $this -> user -> lastName,
            'userKey' =>  $this -> user -> verificationKey,
            "region" => RegionResource::collection(Region::where('id',$this->region_Id)->get())->first(),
            'po_box' => $this -> po_box,
            'hostPosition' => $this -> hostPosition,
            'status' => $this -> status,
            'email_to' => $this -> email_to,
            'addressingTo' => $this -> addressingTo,
            // 'cc_To' => $this -> cc_To,
            // 'others' => $this -> others,
        ];
    }
}
