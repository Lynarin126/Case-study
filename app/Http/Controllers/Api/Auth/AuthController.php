<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $primaryRole = $user->roles()->pluck('slug')->first() ?? 'student';

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => array_merge($user->only(['id', 'name', 'email']), ['role' => $primaryRole]),
            'roles' => $user->roles()->pluck('slug')->values(),
            'permissions' => $user->permissions(),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($studentRole = Role::where('slug', 'student')->first()) {
            $user->roles()->syncWithoutDetaching([$studentRole->id]);
        }

        return response()->json([
            'message' => 'Registration successful',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => array_merge($user->only(['id', 'name', 'email']), ['role' => 'student']),
            'roles' => $user->roles()->pluck('slug')->values(),
            'permissions' => $user->permissions(),
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
