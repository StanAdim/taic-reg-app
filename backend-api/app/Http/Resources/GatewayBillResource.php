<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GatewayBillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this-> id,
            'description' => $this-> description,
            'phone_number' => $this-> phone_number,
            'customer_name' => $this-> customer_name,
            'customer_email' => $this-> customer_email,
            'approved_by' => $this-> approved_by,
            'amount' => $this-> amount,
            'ccy' => $this-> ccy,
            'payment_option' => $this-> payment_option,
            'status_code' => $this-> status_code,
            'expires_at' => $this-> expires_at,
            'payment_order_id' => $this-> payment_order_id,
        ];
    }
}
