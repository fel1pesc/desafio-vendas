<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken($user->id);
        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addHours(9);

        $token->save();

        $user->token = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];

        return response()->json($user, 200);
    }
}
