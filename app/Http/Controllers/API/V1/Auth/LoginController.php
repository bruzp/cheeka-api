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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (Auth::attempt($validator->validated())) {
            $user = User::where('email', $validator->safe()->only('email'))->first();

            $token = $user->createToken('user-token');

            return response()->json(['token' => $token->plainTextToken]);
        }

        return response()->json(null, 422);
    }
}
