<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoothResource;
use App\Models\ExhibitionBooth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExhibitionBoothController extends Controller
{
    public function index()
    {
        return BoothResource::collection(ExhibitionBooth::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'size' => 'required|string',
            'benefit' => 'required|string',
            'amount' => 'required|integer',
            'conference_id' => 'required|string',
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newItem = $validator->validate();
        try{
            $itemCreate = ExhibitionBooth::create($newItem);
            return response()->json([
                'message'=> "New Booth Added",
                'data' => $itemCreate,
                'code'=> 200
            ],200);
        }catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    }
    }

    public function show(ExhibitionBooth $booth)
    {
        try{
            return $booth;
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booth request not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve booth request.'], 500);
        }

    }

    public function update(Request $request, ExhibitionBooth $id)
    {
        try {
            $booth = ExhibitionBooth::findOrFail($id);
            $request->validate([
                'name' => 'required|string',
                'size' => 'required|string',
                'benefit' => 'required|string',
                'amount' => 'required|string',
                'conference_id' => 'required|string',
            ]);

            $booth->update($request->all());

            return response()->json($booth, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booth request not found.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update booth request.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booth = ExhibitionBooth::findOrFail($id);
            $booth->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booth request not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete booth request.'], 500);
        }
    }
}
