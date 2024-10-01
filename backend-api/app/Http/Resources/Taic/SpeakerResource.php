<?php

namespace App\Http\Resources\Taic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeakerResource extends JsonResource
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
            'email' => $this->email,
            'designation' => $this->designation,
            'institution' => $this->institution,
            'linkedinLink' => $this->linkedinLink,
            'twitterLink' => $this->twitterLink,
            'isMain' => $this->isMain,
            'imgPath' =>'Uploads/Speakers/'.$this->imageFileName,
            'is_visible' => $this->is_visible,
            'conferenceYear' => $this->conference->conferenceYear,
            'createdTime' => date('h:i A', strtotime($this->created_at)),
            'createdDate' => date('F j, Y', strtotime($this->created_at)),
        ];
        
    }
}
