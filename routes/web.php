<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LandingPageController;


Route::get('/', [LandingPageController::class, 'index']);


Route::get('/', function () {
    return view('landingpage'); // Your landing page view
});

// Rute untuk halaman register
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

// Rute untuk halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Newsletter Subscription
Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);


Route::get('/', function () {
    return view('welcome');
});


// Route untuk halaman Todo (gunakan view 'todos.blade.php' di resources/views)
Route::get('/todos', function () {
    return view('todos');
});


