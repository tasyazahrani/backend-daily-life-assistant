<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use App\Models\Mood;
use App\Models\SelfCareActivity;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        Auth::login($user);

        return Auth::check()
            ? redirect()->route('dashboard')
            : redirect()->route('login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showDashboard()
    {
        if (Auth::check()) {
            $userId = Auth::id();

            // Todo hari ini
            $todos = Todo::where('user_id', $userId)
                        ->whereDate('created_at', now())
                        ->latest()
                        ->take(5)
                        ->get();

            // Mood terbaru (5 terakhir)
            $mood = Mood::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();


            // Self-care hari ini
            $selfcares = SelfCareActivity::where('user_id', $userId)
                                        ->whereDate('created_at', now())
                                        ->latest()
                                        ->take(5)
                                        ->get();

            // Financial Summary - PILIHAN 1: Semua transaksi
            $income = Transaction::where('user_id', $userId)
                             ->where('type', 'income')
                             ->sum('amount');

            $expenses = Transaction::where('user_id', $userId)
                               ->where('type', 'expense')
                               ->sum('amount');

            // Financial Summary - PILIHAN 2: Bulan ini saja (uncomment jika ingin pakai ini)
            /*
            $income = Transaction::where('user_id', $userId)
                             ->where('type', 'income')
                             ->whereMonth('date', Carbon::now()->month)
                             ->whereYear('date', Carbon::now()->year)
                             ->sum('amount');

            $expenses = Transaction::where('user_id', $userId)
                               ->where('type', 'expense')
                               ->whereMonth('date', Carbon::now()->month)
                               ->whereYear('date', Carbon::now()->year)
                               ->sum('amount');
            */

            $financial = [
                'income' => $income,
                'expenses' => $expenses,
                'balance' => $income - $expenses,
            ];

            return view('dashboard', compact('todos', 'mood', 'selfcares', 'financial'));
        }

        return redirect()->route('login');
    }
}