<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvitationLetterResource;
use App\Mail\ReportInvitationRequest;
use App\Models\InvitationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InvitationRequestController extends Controller
{
     // Fetch all invitation requests
     public function index()
     {
        //for admin
        $auth_user = Auth::user();
        $isAdmin = Auth::user()->role->name === 'admin';
        if($isAdmin){
            return response()->json(InvitationLetterResource::collection(InvitationRequest::all()), 200);
        }
         //for user
        else{
            $user_requests = InvitationLetterResource::collection(InvitationRequest::where('user_id', $auth_user->id)->get());
            return response()->json($user_requests, 200);
        }
     }
 
     // Store a new invitation request
     public function store(Request $request)
     {
         $validated = $request->validate([
             'institutionName' => 'required|string',
             'po_box' => 'required|string',
             'region_Id' => '',
             'addressingTo' => 'required|string',
             'conference_id' => 'required|string',
             'hostPosition' => 'required|string',
             'email_to' => 'required|email',
             'cc_To' => 'nullable|array',
             'others' => 'nullable|array',
         ]);
         $user_id = Auth::id();         
         $user = Auth::user();         
         $reqExist = InvitationRequest::where('conference_id', $request->conference_id)
         ->where('user_id', $user_id)
         ->exists();
        if(!$reqExist){
            $merged_data = array_merge($validated , ['user_id'=> $user_id]);
            $invitationRequest = InvitationRequest::create($merged_data);
            $invData = new InvitationLetterResource($invitationRequest);
            Mail::to('taic@ictc.go.tz')->send(new ReportInvitationRequest($user,$invData));
            Mail::to('info@ictc.go.tz')->send(new ReportInvitationRequest($user,$invData));
            return response()->json($invitationRequest, 201);
        }else{
            return response()->json([
                'message' => "Request for this Event is already Submitted"
            ], 500);
        }

         
     }
 
     // Fetch a specific invitation request
     public function show($id)
     {
        $invitationRequest = InvitationRequest::findOrFail($id);
        // Updating an status
        $invitationRequest->status = !$invitationRequest->status;
        $invitationRequest->save();
         return response()->json(['message' => 'udpdated'], 200);
     }
 
     // Update an existing invitation request
     public function update(Request $request, $id)
     {
         $validated = $request->validate([
             'user_id' => 'sometimes',
             'conference_id' => 'sometimes',
             'institutionName' => '',
             'po_box' => '',
             'region_Id' => '',
             'addressingTo' => '',
             'conference_id' => '',
             'hostPosition' => '',
             'email_to' => 'email',
             'cc_To' => 'nullable|array',
             'others' => 'nullable|array',
         ]);
 
         $invitationRequest = InvitationRequest::findOrFail($id);
         $invitationRequest->update($validated);
         return response()->json($invitationRequest, 200);
     }
 
     // Delete an invitation request
     public function destroy($id)
     {
         $invitationRequest = InvitationRequest::findOrFail($id);
         $invitationRequest->delete();
         return response()->json(null, 204);
     }
}
