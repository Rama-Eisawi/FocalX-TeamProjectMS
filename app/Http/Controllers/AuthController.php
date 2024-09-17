<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFormRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(AuthFormRequest $request)
    {
        $newUser = new User();
        $newUser->user_name = $request->user_name;
        $newUser->email = $request->email;
        // Manually assign and hash the password.
        $newUser->password = Hash::make($request->password);

        $newUser->save();
        $token = JWTAuth::fromUser($newUser);

        return ApiResponse::success(compact('newUser', 'token'), 'User created successfully', 201);
    }

    public function login(AuthFormRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        // Attempt to authenticate the user with the provided credentials
        if (!$token) {
            return ApiResponse::error('Validation error', 401, 'كلمة السر غير صحيحة');
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        // Return a successful response with the user and token
        return ApiResponse::success(compact('user', 'token'), 'User logged in successfully', 200);
    }

    public function logout()
    {
        try {
            // Invalidate the token, so it can no longer be used
            JWTAuth::invalidate(JWTAuth::getToken());

            return ApiResponse::success(null, 'User logged out successfully', 200);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $exception) {
            // Something went wrong while attempting to invalidate the token
            return ApiResponse::error('Logout error', 500, 'فشل تسجيل الخروج، الرجاء المحاولة لاحقا');
        }
    }
}
