<?php

namespace App\Listeners;

use App\Events\PaymentProccessedEvent;
use App\Models\GatewayBill;
use App\Models\GatewaySystem;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class GatewayBillPaymentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentProccessedEvent $event): void
    {
         //
         $bill_data = $event->bill;
         $gatewayBill = GatewayBill::where('bill_id', $bill_data->id)->first();
         $system = GatewaySystem::where('code',$gatewayBill->system_code)->first();
         if($gatewayBill){
             Log::info('Received Payment -----' , ['Bill ID' =>$bill_data->id ]);
             $data = [
                 'message' => "Receive Payment Update",
                 'control_number' => $bill_data-> cust_cntr_num,
                 'status' => $bill_data-> status,
                 'paid_amount' => $bill_data-> paid_amt
             ];
             //making path
             $url = $system->base_url.$system->callback_payment_number.$gatewayBill->uuid;
             // Send the HTTP request with the required headers
             $response = Http::withHeaders([
                 'User-Agent' =>$system->user_agent,
                 'Authorization' => $system->authorization_token,
                 "Accept" => "application/json",
                "ngrok-skip-browser-warning" => 1
             ])->post($url, $data);
             Log::info('------ Payment Data Posted ------');
         }else{
             Log::info('--- Internal  Bill ----');
         }
    }
}
