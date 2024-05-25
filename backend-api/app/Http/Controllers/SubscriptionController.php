<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Event\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function subscribeToEvent($eventId,$eventFee)
    {
        $user_id = Auth::id();
        $newItem = [
            'user_id' => $user_id,
            'conference_id' => $eventId,
        ];
        $userSubscribed = Subscription::where('conference_id', $eventId)
        ->where('user_id', $user_id)
        ->exists();
        if($userSubscribed){
            return response()->json([
                'message'=> ["Your seat already placed!"],
                'code'=> 300
            ]);
        }else{
            $storeData = Subscription::create($newItem);
            $newBill = [
                'user_id' => $user_id,
                'conference_id' =>$eventId,
                'event_fee' => $eventFee,
                'status' => 'pending'
            ];
            $storeData = Bill::create($newBill);
            return response()->json([
                'message'=> "You have subscribed Successfull",
                'data' => $storeData,
                'code'=> 200
            ],200);
        }
    }
}
