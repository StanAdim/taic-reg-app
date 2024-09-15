<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ControllNoReceivedEvent;
use App\Models\GatewayBill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class GatewayControllNoListener
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
    public function handle(ControllNoReceivedEvent $event): void
    {
        //
        $user_agent = 'ICTCAPIUserAgent/1.0';
        $authorization_token = 'Bearer 3|h0rirUCYjh2JRpju7Kb7q0NStcdcOnFsXgVjZwIOddbef43c';
        $bill_data = $event->bill;
        $gatewayBill = GatewayBill::where('bill_id', $bill_data->id)->first();
        if($gatewayBill){
            Log::info('Received Bill -----' , ['Bill ID' =>$bill_data->id ]);
            Log::info('Received For -----' , ['Call back URL' =>$gatewayBill->callback_url]);
            $data = json_encode([
                'message' => "Receive Control number",
                'data' => [
                    'id' => $gatewayBill-> id,
                    'control_number' => $bill_data-> cust_cntr_num
                ]
            ]);
            // Send the HTTP request with the required headers
             Http::withHeaders([
                'User-Agent' =>$user_agent,
                'Authorization' => $authorization_token
            ])->post($gatewayBill->callback_url, $data);
        }else{
            Log::info('--- Internal  Bill ----');
        }
    }
}
