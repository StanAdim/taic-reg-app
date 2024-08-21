<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // Display a listing of the permissions
    public function index()
    {
        $permissions = PermissionResource::collection(Permission::all());
        return response()->json($permissions);
    }

    // Store a newly created permission
    public function store(Request $request)
    {
        $isAdmin = Auth::user()->role->name === 'admin';
        if($isAdmin){
            $request->validate([
                'name' => 'required|unique:permissions,name',
            ]);
    
            $permission = Permission::create($request->only('name'));
    
            return response()->json($permission, 201);
        }
       
    }

    // Display the specified permission
    public function show($id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json($permission);
    }

    // Update the specified permission
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($request->only('name'));

        return response()->json($permission);
    }

    // Remove the specified permission
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json(null, 204);
    }
}
