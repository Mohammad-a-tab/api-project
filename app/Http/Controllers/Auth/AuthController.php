<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request)
    {
        $validatedData = $request->validated();

        User::create($validatedData);

        return
    }
    public function login ()
    {

    }
}
