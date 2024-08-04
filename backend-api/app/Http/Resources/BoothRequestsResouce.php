<?php

namespace App\Http\Resources;

use App\Models\ExhibitionBooth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoothRequestsResouce extends JsonResource
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
            'number'=> $this->number,
            'amount'=> (ExhibitionBooth::where('id',$this->boothId)->first()->amount * $this->number),
            'companyName'=> $this->companyName,
            'booth'=> ExhibitionBooth::where('id',$this->boothId)->first()->name,
            'user'=> User::where('id',$this->user_id)->first()->email,
        ];
    }
}
