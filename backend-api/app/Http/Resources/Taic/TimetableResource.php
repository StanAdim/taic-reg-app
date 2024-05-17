<?php

namespace App\Http\Resources\Taic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableResource extends JsonResource
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
            'startTime'=> $this->startTime,
            'endTime'=> $this->endTime,
            'status'=> $this->status,
            'is_visible'=> $this->is_visible,
            'activities'=> $this->activities,
        ];
    }
}
