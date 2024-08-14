<?php

namespace App\Http\Resources\Taic;

use App\Models\Taic\Conference;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


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
            'user'=>$this->user->firstName.' '.$this->user->middleName. ' '.$this->user->lastName, 
            'conferenceName'=> 'TAIC '.Conference::where('id',$this->conference_id)->first()->conferenceYear, 
            'conferenceFee'=>$this->separateNumber($this->event_fee), 
            'controlNumber'=>$this->cust_cntr_num, 
            'name'=>$this->name, 
            'id'=>$this->id, 
            'user_id'=>$this->user_id, 
            'conference_id'=>$this->conference_id, 
            'status'=> $this->status ? 'PAID': 'NOT PAID',
            'status_code'=>$this->status_code,
            'bill_status_desc'=>$this->status_description,
            'ReqId'=>$this->ReqId,
            'paid_amt'=>$this->paid_amt,
            'trx_id'=>$this->trx_id,
            'bill_amt'=>$this->bill_amt,
            'pyr_name'=>$this->pyr_name,
            'trx_dt_tm'=>Carbon::parse($this->trx_dt_tm)->format('j-m-Y'),
            'created_at'=>Carbon::parse($this->created_at)->format('j-m-Y')
            // 'created_at'=>Carbon::parse($this->created_at)->format('j-m-Y, H:i')
        ];
    }
    
}
