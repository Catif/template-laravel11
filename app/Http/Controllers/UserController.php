<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $input = $request->validated();

        try {
            $user = new User([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'email_verified_at' => now(),
                'role_id' => Role::where('name', 'guest')->first()->id,
            ]);

            $user->save();
        } catch (\Exception $e) {
            return $this->error('Failed to create user', 500);
        }

        return $this->success(UserResource::make($user), 'User created successfully', 201);
    }

    public function me()
    {
        $user = auth()->user();

        if (is_null($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->success(UserResource::make($user));
    }
}
