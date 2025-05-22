<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\FinancialController;
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

Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store']);
Route::post('/todos/{todo}/toggle', [TodoController::class, 'toggle']);
Route::post('/todos/{todo}/delete', [TodoController::class, 'destroy']);
Route::post('/todos/{todo}/update', [TodoController::class, 'update']);

Route::get('/financial', [FinancialController::class, 'index']);
Route::post('/financial', [FinancialController::class, 'store'])->name('financial.store');

// Rute untuk halaman dashboard, hanya bisa diakses setelah login
Route::get('/dashboard', [AuthController::class, 'showDashboard'])->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\ProfileController;

Route::middleware('auth')->get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::middleware('auth')->post('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');

// Middleware auth harus dipakai supaya user harus login dulu
Route::middleware('auth')->group(function () {
    Route::post('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::delete('/profile/delete-account', [App\Http\Controllers\ProfileController::class, 'deleteAccount'])->name('profile.delete-account');
});

Route::prefix('daily-quotes')->name('daily.quotes.')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->name('index');
    Route::post('/', [QuoteController::class, 'store'])->name('store');
    Route::post('/favorite/{id}', [QuoteController::class, 'toggleFavorite'])->name('favorite');
    Route::get('/favorites', [QuoteController::class, 'favorites'])->name('favorites');
    Route::delete('/{id}', [QuoteController::class, 'destroy'])->name('destroy');
    Route::get('/random', [QuoteController::class, 'random'])->name('random');
});
