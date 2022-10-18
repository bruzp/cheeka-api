<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        return response()->json(new UserResource($request->user()));
    }
}
