<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(new UserResource($request->user()));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($request->user())],
        ]);

        if ($validator->fails()) {
            return response()->json(['messages' => $validator->errors()]);
        }

        $request->user()->update($validator->validated());

        return response()->json(['messages' => __('user.updated')]);
    }
}
