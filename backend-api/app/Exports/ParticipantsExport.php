<?php

namespace App\Exports;

use App\Models\Event\Subscription;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantsExport implements FromCollection, WithHeadings
{
    protected $conference_id;

    // Constructor to accept event_id
    public function __construct($conference_id)
    {
        $this->conference_id = $conference_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Subscription::where('conference_id', $this->conference_id)
            ->join('users', 'subscriptions.user_id', '=', 'users.id')  // Join with users table
            ->select(
                'users.firstName', 
                'users.lastName', 
                'users.email'
            )->get();
    }

    public function headings(): array
    {
        return [
            'FIRST NAME', 
            'LAST NAME', 
            'EMAIL'
        ];
    }
}
