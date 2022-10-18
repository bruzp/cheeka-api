<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json(['messages' => $validator->errors()]);
        }

        if (Auth::attempt($validator->validated())) {
            $user = User::where('email', $validator->safe()->only('email'))->first();

            $token = $user->createToken('user-token');

            return response()->json(['token' => $token->plainTextToken]);
        }

        return response()->json(['messages' => ['email' => __('auth.failed')]], 422);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['messages' => __('auth.logout')]);
    }
}
