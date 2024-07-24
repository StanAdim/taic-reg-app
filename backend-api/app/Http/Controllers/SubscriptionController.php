<?php

namespace App\Http\Controllers;

use App\Helpers\XmlRequestHelper;
use App\Http\Resources\SubscribedEvents;
use App\Models\Bill;
use App\Models\Event\Subscription;
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
        $user_id = Auth::id();
        $user = Auth::user();
        $userInfo = $user->userInfo;
        $newItem = [
            'user_id' => $user_id,
            'conference_id' => $eventId,
        ];
        $userSubscribed = Subscription::where('conference_id', $eventId)
        ->where('user_id', $user_id)
        ->exists();
        $userSubscribed = false;
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
                'customer_name' => $user->firstName .' '.$user->lastName,
                'billGeneratedBy' => $user->firstName .' '.$user->lastName,
                'billApproveBy' => 'Billing system',
                'phone_number' => $userInfo->phoneNumber,
                'name' => 'Taic 2024',
                'amount' => $eventFee,
                'GfsCode' => "200.00",
                'email' => $user->email,
                'bill_exp' => Carbon::parse('2030-07-24 12:00:00'),
                'ccy' => "TZS",
                'bill_pay_opt' => 1,
                'status' => 1,
            ];
            $storeData = Bill::create($newBill);
            $returedXml = XmlRequestHelper::GepgSubmissionRequest($storeData);
            $storeData->ReqId = $returedXml["billSubReqAck"]['ReqId'];
            $storeData->save();
            return response()->json([
                'message'=> "You have subscribed Successfull",
                'data' => $storeData,
                'GepgAck' => $returedXml['billSubReqAck'],
                'code'=> 200
            ],200);
        }
    }
}
