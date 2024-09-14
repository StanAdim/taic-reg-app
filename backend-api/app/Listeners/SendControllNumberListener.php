<?php

namespace App\Listeners;

use App\Events\ControllNoReceivedEvent;
use App\Mail\ControllNumberMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendControllNumberListener
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
        $bill_data = $event->bill;
        // Logic to send processed Controll number to email
        Mail::to($bill_data->email)->send(new ControllNumberMail($bill_data));
    }
}
