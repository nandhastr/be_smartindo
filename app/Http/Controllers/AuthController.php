<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Registrasi user baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    // Fungsi login
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Logging aktivitas
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'User logged in',
            ]);

            return response()->json(['message' => 'Login successful', 'user' => $user], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Fungsi logout
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Logging aktivitas
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'User logged out',
        ]);

        Auth::logout();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function activity(){
        $activity = ActivityLog::all();
        return \response()->json($activity);
    }
}
