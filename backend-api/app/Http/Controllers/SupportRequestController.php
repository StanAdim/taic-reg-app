<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupportRequestResource;
use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SupportRequestController extends Controller
{
    // List all support requests (with optional pagination)
    public function index()
    {
        $user = Auth::user();
        $userRequest = SupportRequest::with('responses')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $allRequests = SupportRequest::with('responses')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $isAdmin = Auth::user()->role->name === 'admin';
        $isAdmin ? $requests = $allRequests :$requests = $userRequest;
            
        return SupportRequestResource::collection($requests);
    }

    // Show a single support request
    public function show($id)
    {
        $request = SupportRequest::with('responses')->findOrFail($id);
        return new SupportRequestResource($request);
    }

    // Show a single support request
    public function latestUserRequest()
    {
        try {
            $user = Auth::user();
                $userRequest = SupportRequest::with('responses')
                ->where('user_id', $user->id)
                ->latest() // Get the latest support request
                ->firstOrFail();

                $request = SupportRequest::with('responses')->latest('created_at')
                ->first();
                
            $isAdmin = Auth::user()->role->name === 'admin';
            $isAdmin ? $request = $request : $request = $userRequest;
    
            return new SupportRequestResource($request);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'No support request found for this user.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the support request.'
            ], 500);
        }
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
