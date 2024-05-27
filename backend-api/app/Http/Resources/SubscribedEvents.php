<?php

namespace App\Http\Resources;

use App\Http\Resources\Taic\StrictConference;
use App\Models\Taic\Conference;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscribedEvents extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'event'=> (new StrictConference(Conference::where('id', $this->conference_id)->first()))
        ];
    }
}
