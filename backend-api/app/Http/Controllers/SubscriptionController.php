<?php

namespace App\Http\Controllers;

use App\Helpers\XmlRequestHelper;
use App\Http\Resources\SubscribedEvents;
use App\Models\Bill;
use App\Models\Event\Subscription;
use App\Models\Taic\Conference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    public function subscribeToEvent($eventId,$eventFee)
    {
        // Initialize data 
        $event = Conference::where('id',$eventId)->first();
        $user_id = Auth::id();
        $user = Auth::user();
        $userInfo = $user->userInfo;
        $newItem = ['user_id' => $user_id, 'conference_id' => $eventId,];

        //Check if user has  Subscribed already
        $isUserSubscribed = Subscription::where('conference_id', $eventId)
        ->where('user_id', $user_id)
        ->exists();
        if($isUserSubscribed){
            return response()->json([
                'message'=> "This event is Booked!",
                'code'=> 300
            ]);
        }
        //If not Created Bill for subscription
        else{
            $newBill = [
                'user_id' => $user_id,
                'conference_id' =>$eventId,
                'customer_name' => $user->firstName .' '.$user->lastName,
                'billGeneratedBy' => $user->firstName .' '.$user->lastName,
                'billApproveBy' => 'Billing system',
                'phone_number' => $userInfo->phoneNumber,
                'name' => $event->name,
                'amount' => $eventFee,
                'email' => $user->email,
                'bill_exp' => Carbon::parse('2030-07-24 12:00:00'),
                'ccy' => "TZS",
                'bill_pay_opt' => 1,
                'status' => 0,
            ];
            try {
                $storeData = Bill::create($newBill);
                $returedXml = XmlRequestHelper::GepgSubmissionRequest($storeData);
                if($returedXml){
                $storeData->ReqId = $returedXml["billSubReqAck"]['ReqId'];
                $storeData->save();
                // Subcribe user 
                $storeData = Subscription::create($newItem);
                }
                return response()->json([
                    'message'=> "Subscription Success",
                    'data' => $storeData,
                    'GepgAck' => $returedXml,
                    'code'=> 200
                ],200);

            } catch (\Exception $e) {
                return response()->json(
                    ['error' => 'Failed to create bill', 
                'message' => $e->getMessage(), 'code' => 300]
                , 500);
            }
        }
    }
}
