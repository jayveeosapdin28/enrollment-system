<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
            'token_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => "Invalid credentials."]);
        }

        if (Hash::check($request->input('password'), $user->password)) {
            $token = $user->createToken($request->token_name);
            $user->token = $token->plainTextToken;
            return new UserResource($user);
        } else {
            throw ValidationException::withMessages(['password' => "Email and password do not match."]);
        }

        return response('Authentication Failed', 401);
    }
}
