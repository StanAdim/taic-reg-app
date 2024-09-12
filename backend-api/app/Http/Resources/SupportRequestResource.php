<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportRequestResource extends JsonResource
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
            'user' => $this->user->firstName. ' '.$this->user->lastName ,
            'userKey' => $this->user->verificationKey,
            'subject' => $this->subject,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'responseCount' => $this->responses->count(),
            'responses' =>  SupportResponseResource::collection($this->responses),
        ];
    }
}
