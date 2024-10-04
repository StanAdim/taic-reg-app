<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorshipResource extends JsonResource
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
            'name' => $this->name,
            'category' => $this->category,
            'sub_category' => $this->sub_category,
            'imgPath' =>'Uploads/Sponsors/'.$this->imageFileName,
            'is_visible' => $this->is_visible,
            'conferenceYear' => $this->conference->conferenceYear,
            'conferenceName' => $this->conference->name,
            'createdTime' => date('h:i A', strtotime($this->created_at)),
            'createdDate' => date('F j, Y', strtotime($this->created_at)),
        ];
    }
}
