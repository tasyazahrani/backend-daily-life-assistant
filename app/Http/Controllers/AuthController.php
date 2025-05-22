<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Login pengguna setelah registrasi
    Auth::login($user);

    // Pastikan pengalihan ke dashboard berhasil
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login'); // Jika gagal login
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showDashboard()
{
    if (Auth::check()) {
        // Ambil data todo, bisa juga filter berdasarkan user jika perlu
       $todos = Todo::where('user_id', auth()->id())->get(); // hanya data user login

        // Kirim data ke view dashboard
        return view('dashboard', compact('todos'));
    }
    return redirect()->route('login');
}


    public function logout(Request $request)
    {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');  // Arahkan ke halaman login setelah logout
    }

    public function login(Request $request)
    {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Cek apakah kredensial login valid
    if (Auth::attempt($request->only('email', 'password'))) {
        // Redirect ke dashboard setelah login sukses
        return redirect()->route('dashboard');  // pastikan 'dashboard' adalah rute yang benar
    }

    // Jika gagal login, kembalikan ke halaman login dengan pesan error
    return back()->withErrors(['email' => 'Invalid credentials']);
    }
}