<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteSponsorshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'imgPath' =>'Uploads/Sponsors/'.$this->imageFileName,
        ];
    }
}
