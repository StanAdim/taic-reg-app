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
        if($userInfo->nation != 214){
            $billTobePaid = $event->foreignerFeeInTzs;
        }else{
            $userInfo->professionalStatus ? $billTobePaid = $event->defaultFee : $billTobePaid = $event->guestFee;
        }        
        $newItem = ['user_id' => $user_id, 'conference_id' => $eventId,];

        // Check if user has  Subscribed already
        $isUserSubscribed = Subscription::where('conference_id', $eventId)
        ->where('user_id', $user_id)
        ->exists();
        if($isUserSubscribed){
            return response()->json([
                'message'=> "This event is Booked!",
                'code'=> 300
            ]);
        }
        // If not Created Bill for subscription
        else 
        {
            $newBill = [
                'user_id' => $user_id,
                'conference_id' =>$eventId,
                'customer_name' => $user->firstName .' '.$user->lastName,
                'billGeneratedBy' => $user->firstName .' '.$user->lastName,
                'billApproveBy' => 'Billing system',
                'phone_number' => $userInfo->phoneNumber,
                'name' => $event->name,
                'amount' => $billTobePaid,
                'event_fee' => $billTobePaid,
                'email' => $user->email,
                'bill_exp' => Carbon::now()->addMonths(8)->format('Y-m-d\TH:i:s'),
                'ccy' => "TZS",
                'bill_pay_opt' => 1,
                'status' => 0,
            ];
            try {
                $billData = Bill::create($newBill);
                //check  Freee Events
                if($billTobePaid != 0){
                    $returedXml = XmlRequestHelper::GepgSubmissionRequest($billData);
                    //Check bill is Generated to Gepg
                    if($returedXml){
                        //request ID
                    $billData->ReqId = GeneralCustomHelper::get_string_between($returedXml, '<ReqId>', '</ReqId>');
                    $billData->save();
                    // Subcribe user to event 
                    Subscription::create($newItem);
                    Mail::to($user->email)->send(new SubscriptionToEventMail($user,$event->name));
                    return response()->json([
                        'message'=> "Subscription Success",
                        'data' => $billData,
                        'GepgAck' => $returedXml,
                        'code'=> 200
                    ],200);
                }
                else{
                    DB::table('bills')->where('id', $billData->id)->delete();
                    return response()->json([
                        'message'=> "Bill Generation failed: Gepg Failed",
                        'GepgAck' => $returedXml,
                        'code'=> 300
                    ],500);
                }
            }else{ //Subscribe participant to a free event

                Subscription::create($newItem);
                return response()->json([
                    'message'=> "Subscription Success For Free event",
                    'data' => $billData,
                    'code'=> 200
                ],200);
            }
        } catch (\Exception $e) {
                return response()->json(
                    ['error' => 'Failed to create bill', 
                'message' => $e->getMessage(), 'code' => 300]
                , 500);
            }
        }
    }
}
