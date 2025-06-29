<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'photo' => $data['photo'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('customer');

        return $user->load('roles');
    }

    public function login(array $data)
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.'
            ], 401);
        }

        request()->session()->regenerate();

        $user = Auth::user();

        return response()->json([
            'message' => 'Login Successful',
            'user' => new UserResource($user->load('roles')),
        ]);
    }

    public function tokenLogin(array $data)
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login Successful',
            'token' => $token,
            'user' => new UserResource($user->load('roles')),
        ]);
    }
}
