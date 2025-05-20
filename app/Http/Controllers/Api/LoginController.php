<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // public function login(Request $request)
    // {
    //     try {
    //         $credentials = $request->validate([
    //             'email' => 'required|email',
    //             'password' => 'required',
    //         ]);

    //         $user = User::where('email', $credentials['email'])->first();

    //         if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //             return response()->json([
    //                 'message' => 'Login Gagal.',
    //             ], 401);
    //         }

    //         // $role = $user->role_user ? $user->role_user->role_name : null;
    //         $token = $user->createToken('YourAppName')->plainTextToken;
    //         $user->api_token = $token;
    //         $user->save();

    //         return response()->json([
    //             'message' => 'Login Berhasil',
    //             'user' => [
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'username' => $user->username,
    //                 'email' => $user->email,
    //                 "google_id" => $user->google_id ? $user->google_id : "",
    //                 'avatar' => !empty($user->avatar) && Storage::exists($user->avatar) ? Storage::url($user->avatar) : '',  // Menambahkan pengecekan avatar
    //                 'is_admin' => $user->is_admin
    //             ],
    //             'token' => $token,
    //         ], 200);
    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Validation error',
    //             'errors' => $e->errors(),
    //         ], 422);
    //     }
    // }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }

    // public function logout(Request $request)
    // {

    //     $user = $request->user();
    //     $user->tokens->each(function ($token) {
    //         $token->delete();
    //     });

    //     $user->api_token = null;
    //     $user->save();

    //     return redirect('/login');
    // }

    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'message' => 'Register Berhasil',
                'data' =>  $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }
}
