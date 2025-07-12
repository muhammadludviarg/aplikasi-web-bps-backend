<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
class AuthController extends Controller
{
     // Login method to authenticate users 
    public function login(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => 'required|email', 
            'password' => 'required', 
        ]); 
 
        if (!Auth::attempt($credentials)) { 
            return response()->json(['message' => 'Login gagal'], 401); 
        } 
 
        /** @var \App\Models\User $user */ 
        $user = Auth::user(); 
        $token = $user->createToken('api-token')->plainTextToken; 
 
        return response()->json([ 
            'user' => $user, 
            'token' => $token, 
        ]); 
    } 

    // Logout method to revoke the user's token
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil'], 200); 
    }
}
