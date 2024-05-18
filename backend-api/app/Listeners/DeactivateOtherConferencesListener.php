<?php

namespace App\Listeners;

use App\Events\ConferenceActivated;
use App\Models\Taic\Conference;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeactivateOtherConferencesListener
{
    /**
     * Handle the event.
     */
    public function handle(ConferenceActivated $event): void
    {
        $conference = $event->conference;
        // Deactivate other conferences of the same user
        Conference::where('id', '!=', $conference->id)
        ->update(['lock' => false]);
       
    
    }
}
