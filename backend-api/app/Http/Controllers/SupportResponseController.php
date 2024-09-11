<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupportResponseResource;
use App\Models\SupportRequest;
use App\Models\SupportResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportResponseController extends Controller
{
   
// Store a new response to a support request
public function store(Request $request, $supportRequestId)
{
    $request->validate([
        'response' => 'required',
    ]);

    $supportRequest = SupportRequest::findOrFail($supportRequestId);

    $supportResponse = SupportResponse::create([
        'support_request_id' => $supportRequest->id,
        'user_id' => Auth::id(), // Assuming admin is authenticated via API
        'response' => $request->response,
    ]);

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
