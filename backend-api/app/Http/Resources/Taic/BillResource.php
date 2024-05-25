<?php

namespace App\Http\Resources\Taic;

use App\Models\Taic\Conference;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * 
     */
    
    private function separateNumber($passedNum) {
        if ($passedNum === null || $passedNum === '') {
        }
    
        if (!is_numeric($passedNum)) {
        }
        // Convert to float first to handle numbers in string format
        $num = floatval($passedNum);
    
        // Use number_format to add commas as thousand separators
        $numStr = number_format($num);
        return $numStr;
    }
    public function toArray(Request $request): array
    {
        return [
            'userId'=>$this->user_id, 
            'conferenceName'=> 'TAIC '.Conference::where('id',$this->conference_id)->first()->conferenceYear, 
            'conferenceFee'=>$this->separateNumber($this->event_fee), 
            'controlNumber'=>$this->control_number, 
            'status'=>$this->status
        ];
    }
    
}
