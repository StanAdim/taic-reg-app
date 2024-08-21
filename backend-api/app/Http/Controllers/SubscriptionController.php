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
        } // If not Created Bill for subscription
        else 
        {
            $newBill = [
                'user_id' => $user_id,
                'conference_id' =>$eventId,
                'customer_name' => $user->firstName .' '.$user->middleName.' '.$user->lastName,
                'billGeneratedBy' => $user->firstName .' '.$user->middleName.' '.$user->lastName,
                'billApproveBy' => 'EMS Billing System',
                'payee_name' => 'ICT Commission',
                'phone_number' => $userInfo->phoneNumber,
                'name' => $event->name,
                'amount' => $billTobePaid,
                'reference_no' => GeneralCustomHelper::generateReqID(16),
                'event_fee' => $billTobePaid,
                'remarks' => $event->name. ' - '.$event->conferenceYear,
                'email' => $user->email,
                'sp_code' => env('GEPG_SPCODE'),
                'GfsCode' => env('GEPG_GSFCODE'),
                'SpGrpCode' => env('GEPG_SPGRPCODE'),
                'bill_exp' => Carbon::now()->addMonths(8)->format('Y-m-d\TH:i:s'),
                'ccy' => "TZS",
                'bill_pay_opt' => 3,
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
                        //check for success status
                    $isSuccessful =  GeneralCustomHelper::get_string_between($returedXml, '<AckStsCode>', '</AckStsCode>') == '7101';
                    if($isSuccessful){
                        $billData->ReqId = GeneralCustomHelper::get_string_between($returedXml, '<ReqId>', '</ReqId>');
                        $billData->save();
                        // Subcribe user to event 
                        Subscription::create($newItem);
                        Mail::to($user->email)->send(new SubscriptionToEventMail($user,$event->name));
                        return response()->json([
                            'message'=> "Bill generated Successful",
                            'data' => $billData,
                            'GepgAck' => $returedXml,
                            'code'=> 200
                        ],200);
                    }else {
                        return response()->json([
                        'message'=> $returedXml ? GeneralCustomHelper::get_string_between($returedXml, '<AckStsDesc>', '</AckStsDesc>'): 'No message',
                        'GepgAck' => $returedXml,
                        'code'=> 300
                    ],500);
                    }

                }
                else{
                    DB::table('bills')->where('id', $billData->id)->delete();
                    return response()->json([
                        'message'=> "Bill Generation failed: Gepg failure",
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
