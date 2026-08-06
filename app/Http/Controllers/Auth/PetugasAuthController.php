<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class PetugasAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.petugas.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('petugas')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::guard('petugas')->user()->role !== 'petugas') {
                Auth::guard('petugas')->logout();

                throw ValidationException::withMessages([
                    'email' => 'Akun ini tidak memiliki akses sebagai petugas.',
                ]);
            }

            return redirect()->intended(route('petugas.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.petugas.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
            'role'     => 'petugas',
        ]);

        return redirect()->route('petugas.login')
            ->with('success', 'Registrasi berhasil. Silakan login dengan akun Anda.');
    }

    public function logout(Request $request)
    {
        Auth::guard('petugas')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('petugas.login');
    }
}