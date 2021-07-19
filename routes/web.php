<?php

use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('social/login/{provider}', [SocialiteController::class, 'redirectToProvider'])
        ->name('login.socialite');

    Route::get('social/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])
        ->name('login.socialite.callback');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
