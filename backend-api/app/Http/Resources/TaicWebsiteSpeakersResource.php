<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaicWebsiteSpeakersResource extends JsonResource
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
            'designation' => $this->designation,
            'institution' => $this->institution,
            'linkedinLink' => $this->linkedinLink,
            'twitterLink' => $this->twitterLink,
            
            // 'agenda_title' => $this->agenda_title,
            // 'agenda_desc' => $this->agenda_desc,
            // 'brief_bio' => $this->brief_bio,

            'isMain' => $this->isMain,
            'imgPath' =>'Uploads/Speakers/'.$this->imageFileName,
            'is_visible' => $this->is_visible,
            'conferenceYear' => $this->conference->conferenceYear,
            // 'conferenceName' => $this->conference->name,
            // 'conferenceId' => $this->conference->id,
            // 'createdTime' => date('h:i A', strtotime($this->created_at)),
            // 'createdDate' => date('F j, Y', strtotime($this->created_at)),
        ];
    }
}
