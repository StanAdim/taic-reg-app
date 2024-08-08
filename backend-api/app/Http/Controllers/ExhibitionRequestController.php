<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoothRequestsResouce;
use App\Mail\BoothRequestMail;
use App\Models\ExhibitionBooth;
use App\Models\ExhibitionRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\error;

class ExhibitionRequestController extends Controller
{
    public function index()
    {
        if(Auth::user()->role->name == 'admin'){
            return BoothRequestsResouce::collection(ExhibitionRequest::all());

        }else{
            return BoothRequestsResouce::collection(ExhibitionRequest::where('user_id', Auth::id())->get());

        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'number' => 'required|integer',
            'boothId' => 'required',
            'companyEmail' => 'required|email|max:255',
            'companyName' => 'required|string|max:225',
            'message' => '',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
        $booth = ExhibitionBooth::where('id', $newItem["boothId"])->get()->first();
        try{
            $isExist = ExhibitionRequest::where('boothId', $newItem["boothId"])->exists();
            if(!$isExist){
                $itemCreate = new ExhibitionRequest();
                $itemCreate->boothId  = $newItem['boothId'];
                $itemCreate->number  = $newItem['number'];
                $itemCreate->companyEmail  = $newItem['companyEmail'];
                $itemCreate->message  = $newItem['message'];
                $itemCreate->companyName  = $newItem['companyName'];
                $itemCreate->user_id  = Auth::id();
                $itemCreate->save();
                Mail::to(Auth::user()->email)->send(new BoothRequestMail(Auth::user(),$booth->name));
                return response()->json([
                    'message'=> "Exhibition booth Request submitted",
                    'code'=> 200
                ],200);
            }else{
                return response()->json([
                    'message'=> "You've booked this booth",
                    'code'=> 300
                ],500);
            }
        }catch (Exception $e) {
        return response()->json(['errors' => $e->getMessage()], 500);
    }
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
