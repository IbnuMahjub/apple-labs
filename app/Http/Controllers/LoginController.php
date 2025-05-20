<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->with('loginError', 'Email atau password salah.');
        }

        // Simpan data user ke session
        Session::put('user', [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'avatar' => $user->avatar,
        ]);

        Session::put('login_time', now());

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Berhasil login!');
        // $url = env('APP_URL') . '/api/login_api';

        // try {
        //     // dd(env('API_URL'));

        //     Log::info('URL yang dipanggil: ' . $url);

        //     $response = Http::timeout(5)->post($url, [
        //         'email' => $validated['email'],
        //         'password' => $validated['password'],
        //     ]);

        //     dd($response->body());
        //     Log::info('Response status: ' . $response->status());
        //     if ($response->status() === 401) {
        //         $errorMessage = $response->json()['message'] ?? 'Login failed. Please check your credentials.';
        //         return back()->with('loginError', $errorMessage);
        //     }

        //     if ($response->successful()) {
        //         $data = $response->json();

        //         Session::put('token', $data['token']);
        //         Session::put('user', $data['user']);
        //         Session::put('login_time', now());

        //         return redirect('/dashboard');
        //     }

        //     return back()->with('loginError', 'An unknown error occurred. Please try again.');
        // } catch (\Exception $e) {
        //     Log::error('Error saat login API: ' . $e->getMessage());
        //     return back()->with('loginError', 'Maaf Sedang Ada gangguan');
        // }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // dd($googleUser);
            $url = env('API_URL') . '/api/login/google';

            $response = Http::post($url, [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Session::put('token', $data['token']);
                Session::put('user', $data['user']);
                return redirect('/dashboard');
            }

            return redirect('/login')->with('loginError', 'Google login gagal.');
        } catch (\Exception $e) {
            return redirect('/login')->with('loginError', 'Terjadi kesalahan.');
        }
    }



    public function logout()
    {
        $token = session('token');
        $url = env('API_URL') . '/api/logout';

        try {
            $response = Http::withToken($token)->post($url);
            if ($response->successful()) {
                Session::forget('token');
                Session::forget('user');

                Session::flush();
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            Session::forget('token');
            Session::forget('user');

            Session::flush();
            return redirect()->route('login');
        }
    }

    public function register()
    {
        return view('register', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    /**
     * Display the reset password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function v_resetpassword()
    {
        return view('reset', [
            'title' => 'Reset Password',
            'active' => 'reset-password'
        ]);
    }

    // ini untuk jika sudah berhasil reset password
    public function getTokenEmail(Request $request)
    {
        $token = $request->query('token');
        return view('form_reset', [
            'title' => 'Login',
            'active' => 'login',
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $url = env('API_URL') . '/api/reset-password';
        $response = Http::post($url, [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'password_confirmation' => $validated['password_confirmation'],
            'token' => $request->token
        ]);

        try {
            if ($response->successful()) {
                $data = $response->json();
                return redirect('/login')->with('success', $data['message']);
            }
            return back()->with('loginError', 'An unknown error occurred. Please try again.');
        } catch (\Throwable $th) {
            return redirect('/login');
        }
    }

    public function sendEmail(Request $request)
    {
        $email = $request->email;

        $url = env('API_URL') . '/api/forgot-password';
        $response = Http::post($url, ['email' => $email]);
        try {
            if ($response->successful()) {
                $data = $response->json();
                return redirect('/lupa-password')->with('success', $data['message']);
            }
            return back()->with('loginError', 'An unknown error occurred. Please try again.');
        } catch (\Throwable $th) {
            return back()->with('loginError', 'Maaf Sedang Ada gangguan');
        }
    }

    // public function storeRegister(Request $request)
    // {
    //     $validated = $request->validate([
    //         'username' => 'required|string',
    //         'email' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     $url = env('API_URL') . '/api/register';

    //     try {
    //         $response = Http::post($url, [
    //             'username' => $validated['username'],
    //             'email' => $validated['email'],
    //             'password' => $validated['password'],
    //         ]);

    //         // dd($response->status(), $response->json());

    //         if ($response->successful()) {
    //             $data = $response->json();
    //             return redirect('/login')->with('success', $data['message']);
    //         }

    //         if ($response->status() === 422) {
    //             $responseData = $response->json();
    //             if (isset($responseData['errors'])) {
    //                 return back()->withErrors($responseData['errors'])->withInput();
    //             }
    //         }

    //         return back()->with('loginError', 'An unknown error occurred. Please try again.');
    //     } catch (\Throwable $th) {
    //         return back()->with('loginError', $th->getMessage());
    //     }
    // }

    // cara simple
    public function storeRegister(Request $request)
    {
        $url = env('API_URL') . '/api/register';

        $response = Http::post($url, $request->all());

        if ($response->failed() && $response->status() === 422) {
            return back()->withErrors($response->json('errors'))->withInput();
        }

        return redirect('/login')->with('success', 'Register berhasil!');
    }
}
