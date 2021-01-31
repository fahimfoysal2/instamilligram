<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * User Login
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::user();
            $token = $user->createToken($user->email);
            return response()->json([
                'user' => $user->id,
                'accessToken' => $token->accessToken,
            ]);
        } else
            return response()->json('error');

    }

    /**
     * Logout User
     * revoke token
     */
    public function logout()
    {
        // logout user
    }
}
