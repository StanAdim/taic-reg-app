<?php

namespace App\Http\Controllers;

use App\Models\ExhibitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExhibitionRequestController extends Controller
{
    public function index()
    {
        return ExhibitionRequest::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|number',
            'companyEmail' => 'required|email|max:255',
            'companyName' => 'required|string|max:15',
        ]);
        $id = Auth::id();
        $user_id = ['user_id' => $id];
        $newData = array_merge($user_id ,$request->all());
        $boothRequest = ExhibitionRequest::create($newData);

        return response()->json($boothRequest, 201);
    }

    public function show(ExhibitionRequest $boothRequest)
    {
        return $boothRequest;
    }

    public function update(Request $request, ExhibitionRequest $boothRequest)
    {
        $boothRequest->update($request->all());

        return response()->json($boothRequest, 200);
    }

    public function destroy(ExhibitionRequest $boothRequest)
    {
        $boothRequest->delete();

        return response()->json(null, 204);
    }
}
