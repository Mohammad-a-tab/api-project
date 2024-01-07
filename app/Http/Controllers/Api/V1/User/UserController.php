<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Requests\Api\V1\User\UserStoreRequest;
use App\Http\Requests\Api\V1\User\UserUpdateRequest;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    use JsonResponseTrait;
    public function index()
    {
        //
    }

    public function store(UserStoreRequest $request)
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
    public function show(Request $request)
    {
        $user = JWTAuth::authenticate($request->bearerToken());

        return $user ? response()->json(['user' => $user]) : 'User Not Fount';
    }
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $validatedData = $request->validated();

            if(!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($validatedData);

            return $this->successResponse(
                'اطلاعات کاربر با موفقیت ویرایش شد',
                null,
                ResponseAlias::HTTP_OK)
                ;

        } catch (\Exception $e) {
            return $this->errorResponse(
                'عملیات با مشکل مواجه شد',
                $e->getCode(),
                $e->getMessage()
            );
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
