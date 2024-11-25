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
    Route::get('/funds' , [\App\Http\Controllers\FundController::class , 'getFunds']);
    Route::get('/add-fund' , [\App\Http\Controllers\FundController::class , 'addFund']);
    Route::get('/fund/{fund}' , [\App\Http\Controllers\FundController::class , 'editFund']);
    Route::post('/save-fund' , [\App\Http\Controllers\FundController::class , 'saveFundStock']);
    Route::get('/delete-fund/{id}' , [\App\Http\Controllers\FundController::class , 'removeMapping']);
    Route::get('/live-fund' , [\App\Http\Controllers\FundController::class , 'showLiveFunds']);
});
