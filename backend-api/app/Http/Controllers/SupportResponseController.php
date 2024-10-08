<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupportResponseResource;
use App\Mail\ReportRaisedIssueResponse;
use App\Models\SupportRequest;
use App\Models\SupportResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportResponseController extends Controller
{
   
// Store a new response to a support request
public function store(Request $request)
{
    $request->validate([
        'response' => 'required',
        'supportRequestId' => 'required',
    ]);

    $supportRequest = SupportRequest::findOrFail($request->supportRequestId);

    $supportResponse = SupportResponse::create([
        'support_request_id' => $supportRequest->id,
        'user_id' => Auth::id(), // Assuming admin is authenticated via API
        'response' => $request->response,
    ]);
    $submitter = $supportRequest->user;
    Mail::to($submitter->email)->send(new ReportRaisedIssueResponse());
    // Optionally update the support request's status to closed
    $supportRequest->status = 'closed';
    $supportRequest->save();

    return new SupportResponseResource($supportResponse);
}

// Show a single response (optional)
public function show($id)
{
    $response = SupportResponse::findOrFail($id);
    return new SupportResponseResource($response);
}
}
