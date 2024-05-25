<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserInfoResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request) : Response
    {
        $status = $request->authenticate();
        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
    
    public function  authUserCall(Request $request){
        $user = $request->user();
        if($user){
            // Customize the response
            $role = RoleResource::collection(Role::where('id',$user->role_id)->get())->first();
            $extraInfo = null;
            if($user->hasInfo == 1){
                $extraInfo = new UserInfoResource($user->userInfo);
            }
             return response()->json([
            'user' => $user,
            'role' => $role,
            'userInfo' => $extraInfo,
            'message' => 'Authenticated user success'
        ]);
        }
        return $request->user();
    }
}
