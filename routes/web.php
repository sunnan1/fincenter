<?php

use Illuminate\Support\Facades\Route;

Route::get('auth/google', [\App\Http\Controllers\SocialController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [\App\Http\Controllers\SocialController::class, 'handleGoogleCallback']);
Route::get('/login', function () {
    if(\Illuminate\Support\Facades\Auth::check())
        return redirect('/');
    return view('login');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/' , [\App\Http\Controllers\SummaryController::class , 'index']);
});
