<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isPetugas()) {
                return redirect()->intended('/petugas/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'nik' => 'required|string|size:16|unique:users',
            'foto_identitas' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_selfie' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $fotoIdentitasPath = $request->file('foto_identitas')->store('foto_user', 'public');

        $fotoSelfiePath = $request->file('foto_selfie')->store('foto_user', 'public');

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'nik' => $validated['nik'],
            'foto_identitas' => $fotoIdentitasPath,
            'foto_selfie' => $fotoSelfiePath,
            'role' => 'masyarakat',
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
