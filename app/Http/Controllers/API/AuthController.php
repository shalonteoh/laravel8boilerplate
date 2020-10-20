<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $userData = $request->only(config('validation.auth.signup.fields'));

        $user = User::create($userData);

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ]);
    }

    public function getUser(Request $request)
    {
        return response()->json([
            'data' => $request->user()
        ]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new AccessDeniedHttpException(__('auth.login.failed'));
        }

        $user->tokens()->where('name', '=', $request->device_name)->delete();

        $token =  $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'data' => [
                'token' => $token,
                'user' => $user,
            ]
        ]);
    }

    public function sendEmailVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        $status = back()->with('status', 'verification-link-sent');

        return response()->json([
            'data' => $status
        ]);
    }
}