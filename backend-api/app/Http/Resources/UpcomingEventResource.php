<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'id' => $this->id,
            'conferenceName'=> 'TAIC - '.$this->conferenceYear,
            'year'=> $this->conferenceYear,
            'conferenceYear' => $this->conferenceYear,
            'startDate' => date('j F Y', strtotime($this->startDate)),
            'endDate' => date('j F Y', strtotime($this->endDate)),
            'name' => $this->name,
            'venue' => $this->venue,
            'theme' => $this->theme,
            'aboutConference' => $this->aboutConference,
            'defaultFee' => $this->defaultFee,
            'foreignerFee' => $this->foreignerFee,
            'foreignerFeeInTzs' => $this->foreignerFeeInTzs,
            'guestFee' => $this->guestFee,
            'isFree' => $this->defaultFee === 0 & $this->guestFee  === 0 ,
            'lock' => $this->lock,
            'status' => $this->status,
            'createdTime' => date('h:i A', strtotime($this->created_at)),

        ];
    }
}
