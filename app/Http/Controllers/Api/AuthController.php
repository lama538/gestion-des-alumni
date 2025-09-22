<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // <-- corrigé ici
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,etudiant,entreprise,alumni'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role'=> $request->role
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string'
    ]);

    // Normaliser l'email
    $credentials = $request->only('email', 'password');
    $credentials['email'] = strtolower($credentials['email']);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid login',
            'errors' => ['email' => ['Email ou mot de passe incorrect']]
        ], 401);
    }

    $user = Auth::user(); // utilisateur authentifié
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
