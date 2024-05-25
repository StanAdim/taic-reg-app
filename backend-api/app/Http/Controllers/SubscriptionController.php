<?php

namespace App\Http\Controllers;

use App\Models\Event\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function subscribeToEvent($eventId)
    {
        $user_id = Auth::id();
        $newItem = [
            'user_id' => $user_id,
            'conference_id' => $eventId,
        ];
        $storeData = Subscription::create($newItem);
        return response()->json([
            'message'=> "You have subscribed Successfull",
            'data' => $storeData,
            'code'=> 200
        ],200);
    }
}
