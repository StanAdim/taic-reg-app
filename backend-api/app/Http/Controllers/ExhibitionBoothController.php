<?php

namespace App\Http\Controllers;

use App\Models\ExhibitionBooth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExhibitionBoothController extends Controller
{
    public function index()
    {
        return ExhibitionBooth::all();
    }

    public function store(Request $request)
    {
  
        try{
            $request->validate([
                'number' => 'required|number',
                'companyEmail' => 'required|email|max:255',
                'companyName' => 'required|string|max:255',
                'message' => '',
            ]);
            $booth = ExhibitionBooth::create($request->all());
    
            return response()->json($booth, 201);
        }
        catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create booth request.'], 500);
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
                'number' => 'required|number',
                'companyEmail' => 'required|email|max:255',
                'companyName' => 'required|string|max:255',
                'message' => '',
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
