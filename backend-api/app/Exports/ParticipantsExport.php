<?php

namespace App\Exports;

use App\Models\Event\Subscription as EventSubscription;
use Maatwebsite\Excel\Concerns\FromCollection;

class ParticipantsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EventSubscription::all();
    }
}
