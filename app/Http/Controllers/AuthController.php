<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $input = $request->validated();
        $credentials = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];

        if (!auth()->attempt($credentials)) {
            return $this->error('Unauthorized', 401);
        }

        $user = auth()->user();
        $user->refresh_token = fake()->lexify("??????????????????????????????????????????????????????");
        $user->save();

        $token = auth()->login($user);


        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        // fake refresh to take payload
        auth()->refresh(false, true);

        $user = auth()->user();
        $payload = auth()->payload()->toArray();

        $userNotFound = is_null($user);
        $haventRefreshToken = $user?->refresh_token === null;
        $noRefreshToken = !isset($payload['refresh_token']);
        if ($userNotFound || $haventRefreshToken || $noRefreshToken) {
            return response()->json(['error' => 'This token is invalid'], 401);
        }

        $refreshTokenDiffer = $user?->refresh_token !== $payload['refresh_token'];
        if ($userNotFound || $haventRefreshToken || $refreshTokenDiffer) {
            return response()->json(['error' => 'This token is expired'], 401);
        }

        return $this->respondWithToken(auth()->refresh(false, true));
    }

    protected function respondWithToken($token)
    {
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
