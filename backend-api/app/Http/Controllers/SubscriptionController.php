<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralCustomHelper;
use App\Helpers\XmlRequestHelper;
use App\Http\Resources\SubscribedEvents;
use App\Mail\SubscriptionToEventMail;
use App\Models\Bill;
use App\Models\Event\Subscription;
use App\Models\Taic\Conference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function subscribedEvents(){
        $authUser = Auth::user();
        $events = SubscribedEvents::collection($authUser->subscriptions);
            return response()->json([
                'message'=> "Subscribed events",
                'data' => $events,
                'code'=> 200
            ],200);

    }

    public function subscribeToEvent($eventId)
    {
        // Initialize data 
        $event = Conference::where('id',$eventId)->first();
        $user_id = Auth::id();
        $user = Auth::user();
        $userInfo = $user->userInfo;
        $billTobePaid = 0;
        Log::info("--------- Mantainance Mode -------");

        return response()->json([
            'message'=> "Bill Generation failed: Gepg failure",
            'GepgAck' => null,
            'code'=> 300
        ],402);
    }
    public function unsubscribeUserFromEvent(Request $request){
        // Check if the user is subscribed to the event
        $validator = Validator::make($request->all(),[
            'event_id' => 'required',
            'user_id' => 'required', ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
        $subscription = DB::table('subscriptions')
            ->where('user_id', $newItem["user_id"])
            ->where('conference_id', $newItem["event_id"])
            ->first();
            $authUser = Auth::user();
            $isAdmin = $authUser->role->name == "admin";

        if ($subscription && $isAdmin ) {
            // Unsubscribe the user from the event
            DB::table('subscriptions')
                ->where('user_id', $newItem["user_id"])
                ->where('conference_id', $newItem["event_id"])
                ->delete();

            // Return a success response
            return response()->json([
                'message' => "User unsubscribed from the event successfully.",
                'code' => 200
            ], 200);
        } else {
            // Return an error response if the user was not subscribed
            return response()->json([
                'message' => "User is not subscribed to this event.",
                'code' => 404
            ], 404);
        }

    }
}
