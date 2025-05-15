<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MoodTrackerController;


Route::get('/', [LandingPageController::class, 'index']);


Route::get('/', function () {
    return view('landingpage'); // Your landing page view
});

// Rute untuk menampilkan form registrasi (GET)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/mood', [MoodTrackerController::class, 'index'])->name('mood');
Route::post('/mood', [MoodTrackerController::class, 'store'])->name('mood.store');

// Newsletter Subscription
Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\TodoController;

Route::get('/todos', [TodoController::class, 'index']);
Route::post('/todos', [TodoController::class, 'store']);
Route::post('/todos/{todo}/toggle', [TodoController::class, 'toggle']);
Route::post('/todos/{todo}/delete', [TodoController::class, 'destroy']);
Route::post('/todos/{todo}/update', [TodoController::class, 'update']);


// Rute untuk halaman dashboard, hanya bisa diakses setelah login
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
