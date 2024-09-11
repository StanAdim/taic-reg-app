<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResponseResource extends JsonResource
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
            'responder' => $this->user->firstName. ' '.$this->user->lastName ,
            'response' => $this->response,
            'created_at' => $this->created_at,
        ];
    }
}
