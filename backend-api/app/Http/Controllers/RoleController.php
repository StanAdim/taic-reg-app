<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = RoleResource::collection(Role::all());
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $isAdmin = Auth::user()->role->name === 'admin';
        if($isAdmin){
            $validatedData = $request->validate([
                'name' => 'required|string|unique:roles',
            ]);
    
            $role = Role::create($validatedData);
    
            return response()->json($role, Response::HTTP_CREATED);
        }
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update($validatedData);

        return response()->json($role);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
