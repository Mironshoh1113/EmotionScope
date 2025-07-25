<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\HomepageContent;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->check() || !auth()->user()->is_admin) {
                abort(403, 'Sizda admin huquqi yo‘q!');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.index')->with('success', 'Foydalanuvchi o‘chirildi!');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function editProfile()
    {
        $user = auth()->user();
        return view('admin.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
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
        return redirect()->route('admin.profile')->with('success', 'Profil yangilandi!');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-profile', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'is_admin' => ['required', 'boolean'],
        ]);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->is_admin = $data['is_admin'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        return redirect()->route('admin.users.show', $user->id)->with('success', 'Foydalanuvchi yangilandi!');
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        return redirect()->route('admin.users.show', $user->id)->with('success', $user->is_blocked ? 'Foydalanuvchi bloklandi!' : 'Foydalanuvchi blokdan chiqarildi!');
    }
} 