<?php

namespace App\Http\Resources\Taic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'conferenceYear' => $this->conferenceYear,
            'startDate' => date('j F Y', strtotime($this->startDate)),
            'endDate' => date('j F Y', strtotime($this->endDate)),
            'venue' => $this->venue,
            'theme' => $this->theme,
            'aboutConference' => $this->aboutConference,
            'defaultFee' => $this->defaultFee,
            'foreignerFee' => $this->foreignerFee,
            'businessSector' => $this->businessSector,
            'guestFee' => $this->guestFee,
            'lock' => $this->lock,
            'createdTime' => date('h:i A', strtotime($this->created_at)),
            'createdDate' => date('j F Y', strtotime($this->created_at)),
            'speakers' => $this->speakers,
            'days'=> DayResource::collection($this-> days) 
            ];   
    }
}
