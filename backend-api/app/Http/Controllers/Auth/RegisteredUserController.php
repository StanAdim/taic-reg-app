<?php

namespace App\Http\Controllers\Auth;

use App\Exports\UsersExport;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;



class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
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
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'firstName' => [''],
            'middleName' => [''],
            'lastName' => [''],
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newData = $validator->validate();
        $id = Auth::id();
        User::where('id',$id)->update($newData);
        return response()->json([
            'message'=> 'Data updated!',
            'data' => $newData,
            'code' => 200
         ]);
    }

    // Admin update user data 
    public function adminUpdateUser($userKey, Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=> 'Validation fails',
                'errors'=> $validator->errors()
            ],422);
        }
        $newData = $validator->validate();
        $id = User::where('verificationKey',$userKey)->get()->first()->id;
        User::where('id',$id)->update($newData);
        return response()->json([
            'message'=> 'Data updated!',
            'code' => 200
         ]);
    }
    public function adminUpdateRole($userKey, $roleId){
        $user = User::where('verificationKey',$userKey)->get()->first();
        $user->role_id = $roleId;
        $user->save();
        return response()->json([
            'message'=> 'User role updated!',
            'code' => 200
         ]);
    }
    public function passwordResetting(Request $request){
            // Validate the incoming request
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8|confirmed',
                'token' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }
            // Find the user by the provided token
            $user = User::where('verificationKey', $request->token)->first();
            // If no user is found with the token, return an error response
            if (!$user) {
                return response()->json(['message' => 'Invalid token.'], 404);
            }
            // Attempt to reset the user's password
            $user->password = Hash::make($request->password);
            $user->save();

            // Return a success response
            return response()->json(['message' => 'Password has been reset successfully.'], 200);
        }
       
}
