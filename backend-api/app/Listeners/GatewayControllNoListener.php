<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ControllNoReceivedEvent;
use App\Models\GatewayBill;
use App\Models\GatewaySystem;
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
    public function handle(ControllNoReceivedEvent $event): void{
        //
        $bill_data = $event->bill;
        $gatewayBill = GatewayBill::where('bill_id', $bill_data->id)->first();
        $system = GatewaySystem::where('code',$gatewayBill->system_code)->first();
        if($gatewayBill){
            Log::info('Received Bill -----' , ['Bill ID' =>$bill_data->id ]);
            $data = json_encode([
                'message' => "Receive Control number",
                'data' => [
                    'control_number' => $bill_data-> cust_cntr_num
                ]
            ]);
            //making path
            $url = $system->base_url.$system->callback_controll_number.$gatewayBill->uuid;
            // Send the HTTP request with the required headers
            $response = Http::withHeaders([
                'User-Agent' =>$system->user_agent,
                'Authorization' => $system->authorization_token
            ])->post($url, $data);

            Log::info('------ Controll number Data Posted ------');
        }else{
            Log::info('--- Internal  Bill ----');
        }
    }
}
