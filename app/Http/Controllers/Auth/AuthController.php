<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\AuthRegisterRequest;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    use JsonResponseTrait;

    public function register(AuthRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $validatedData['password'] = Hash::make($validatedData['password']);

            User::create($validatedData);

            return $this->successResponse('کاربر با موفقیت ایجاد شد', '', 201);

        } catch (\Exception $e) {
            return $this->errorResponse('عملیات با مشکل مواجه شد', $e->getCode(), $e->getMessage());
        }
    }

    public function login()
    {

    }
}
