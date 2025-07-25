<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        return redirect()->route('profile.show')->with('success', 'Profil yangilandi!');
    }

    public function sendRequest(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'text' => 'required|string|max:1000',
        ]);
        // Limit va balans tekshirish
        if ($user->requests_used >= $user->request_limit) {
            return redirect()->back()->with('error', __('request_limit'));
        }
        // Matn tahlili (mock)
        $text = $request->input('text');
        // Demo uchun random natija
        $types = ['positive', 'negative', 'neutral', 'offensive', 'other'];
        $result_type = $types[array_rand($types)];
        $response = 'Demo javob: ' . ucfirst($result_type);
        // So'rovni bazaga yozish
        $userRequest = $user->requests()->create([
            'text' => $text,
            'result_type' => $result_type,
            'response' => $response,
        ]);
        // Statistika yangilash
        $stat = $user->requestStats()->firstOrCreate([
            'user_id' => $user->id,
            'type' => $result_type
        ]);
        $stat->count += 1;
        $stat->save();
        // Limitni oshirish
        $user->requests_used += 1;
        $user->save();
        return redirect()->route('profile.requests')->with('success', __('send') . ' OK!');
    }

    public function info()
    {
        $user = Auth::user();
        return view('profile.info', compact('user'));
    }
    public function balance()
    {
        $user = Auth::user();
        return view('profile.balance', compact('user'));
    }
    public function stats()
    {
        $user = Auth::user();
        return view('profile.stats', compact('user'));
    }
    public function requests()
    {
        $user = Auth::user();
        return view('profile.requests', compact('user'));
    }
} 