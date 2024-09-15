<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ControllNoReceivedEvent;
use Illuminate\Support\Facades\Log;

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
        $bill_data = $event->bill;
        Log::info('----- Received Bill' , ['Bill ID' =>$bill_data->id ]);
    }
}
