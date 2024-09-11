<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupportRequestResource;
use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportRequestController extends Controller
{
    // List all support requests (with optional pagination)
    public function index()
    {
        $requests = SupportRequest::with('responses')->orderBy('created_at', 'desc')->paginate(10); // Or you can use all() for all requests
        return SupportRequestResource::collection($requests);
    }

    // Show a single support request
    public function show($id)
    {
        $request = SupportRequest::with('responses')->findOrFail($id);
        return new SupportRequestResource($request);
    }

    // Store a new support request
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);
        $supportRequest = SupportRequest::create([
            'user_id' => Auth::id(), // Assuming attendee is authenticated via API
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return new SupportRequestResource($supportRequest);
    }

    // Update an existing support request (optional)
    public function update(Request $request, $id)
    {
        $supportRequest = SupportRequest::findOrFail($id);

        $supportRequest->update($request->only(['subject', 'message', 'status']));

        return new SupportRequestResource($supportRequest);
    }

    // Delete a support request (optional)
    public function destroy($id)
    {
        $supportRequest = SupportRequest::findOrFail($id);
        $supportRequest->delete();

        return response()->json(['message' => 'Support request deleted successfully'], 200);
    }
}
