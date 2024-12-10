<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data 
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'nullable|in:admin,customer', 
        ]);

        // Cek role
        $role = $data['role'] ?? 'customer';  
        
        // Buat pengguna baru
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,  // Tetapkan role yang benar
        ]);

        // Login otomatis setelah pendaftaran berhasil
        auth()->login($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, Silahkan Login');
    }
}
