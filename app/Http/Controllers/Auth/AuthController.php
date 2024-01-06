<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\AuthLoginRequest;
use App\Http\Requests\Api\V1\Auth\AuthRegisterRequest;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    use JsonResponseTrait;

    public function register(AuthRegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $validatedData['password'] = Hash::make($validatedData['password']);

            User::create($validatedData);

            return $this->successResponse(
                'کاربر با موفقیت ایجاد شد',
                null,
                ResponseAlias::HTTP_CREATED)
                ;

        } catch (\Exception $e) {
            return $this->errorResponse(
                'عملیات با مشکل مواجه شد',
                $e->getCode(),
                $e->getMessage()
            );
        }
    }

    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::query()->where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('کاربری یافت نشد', ResponseAlias::HTTP_NOT_FOUND);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);

        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

}
