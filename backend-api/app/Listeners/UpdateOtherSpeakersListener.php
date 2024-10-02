<?php

namespace App\Listeners;

use App\Events\MainSpeakerUpdated;
use App\Models\Taic\Speaker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateOtherSpeakersListener
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
    public function handle(MainSpeakerUpdated $event)
    {
        // Set all other speakers of the event to not be main
        Speaker::where('event_id', $event->conference_id)
            ->where('id', '!=', $event->speaker_id)
            ->update(['isMain' => false]);
    }
}
