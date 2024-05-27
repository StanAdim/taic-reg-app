<?php

namespace App\Http\Resources\Taic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StrictConference extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'conferenceName'=> 'TAIC - '.$this->conferenceYear,
            'conferenceYear' => $this->conferenceYear,
            'id' => $this->id,
            'startDate' => date('j F Y', strtotime($this->startDate)),
            'endDate' => date('j F Y', strtotime($this->endDate)),
            'venue' => $this->venue,
            'theme' => $this->theme,
        ];
    }
}
