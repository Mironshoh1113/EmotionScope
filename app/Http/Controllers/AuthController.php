<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Login yoki parol noto‘g‘ri.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Bepul tarifni topish
        $freePlan = Plan::where('price', 0)->where('is_active', true)->first();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
            'oken' => bin2hex(random_bytes(16)),
            'plan_id' => $freePlan ? $freePlan->id : null,
            'balance' => 0,
            'request_limit' => $freePlan ? $freePlan->request_limit : 1000,
            'requests_used' => 0,
        ]);

        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = \App\Models\User::where('email', $googleUser->getEmail())->first();
        if (!$user) {
            // Bepul tarifni topish
            $freePlan = Plan::where('price', 0)->where('is_active', true)->first();
            
            $user = \App\Models\User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)),
                'is_admin' => false,
                'oken' => bin2hex(random_bytes(16)),
                'plan_id' => $freePlan ? $freePlan->id : null,
                'balance' => 0,
                'request_limit' => $freePlan ? $freePlan->request_limit : 1000,
                'requests_used' => 0,
            ]);
        }
        \Auth::login($user);
        return redirect('/');
    }
} 