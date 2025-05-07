<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index']);


Route::get('/', function () {
    return view('landingpage'); // Your landing page view
});

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Newsletter Subscription
Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);


Route::get('/', function () {
    return view('welcome');
});
