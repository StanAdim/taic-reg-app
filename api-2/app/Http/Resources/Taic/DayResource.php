<?php

namespace App\Http\Resources\Taic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
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
            'conferenceYear' => $this->conference->conferenceYear,
            'label' => $this->label,
            'date' => $this->date,
            'status' => $this->status,
            'is_visible' => $this->is_visible,
            'createdTime' => date('h:i A', strtotime($this->created_at)),
            'createdDate' => date('F j, Y', strtotime($this->created_at)),
            'timetable'=>  TimetableResource::collection($this->timetables)
            ];   
    }
}
