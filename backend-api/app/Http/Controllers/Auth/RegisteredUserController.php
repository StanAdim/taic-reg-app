<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomEmailVerification;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'middleName' => [''],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        $attendeeRole = Role::where('name', 'attendee')->first();
        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'middleName' => $request->middleName,
            'email' => $request->email,
            'role_id'=> $attendeeRole->id,
            'verificationKey' => strtolower(Str::random(32)),

            'password' => Hash::make($request->password),
        ]);

        $baseUrl = config('app.frontend_url');
        $url = $baseUrl . '/verify-user-account-' . $user->verificationKey;
        Mail::to($user->email)->send(new CustomEmailVerification($user,$url));

        event(new Registered($user));

        return response()->json([
                'message'=> "Registration Success: Check Your Inbox",
                'data' => $user,
                'code' => 200
            ]
        );
    }
}
