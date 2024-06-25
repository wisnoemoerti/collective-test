<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/deposit', function () {
        return view('deposit');
    })->name('deposit');

    Route::post('/deposit', [PaymentController::class, 'deposit']);

    Route::get('/withdraw', function () {
        return view('withdraw');
    })->name('withdraw');

    Route::post('/withdraw', [PaymentController::class, 'withdraw']);

    Route::get('/dashboard', [PaymentController::class, 'dashboard'])->name('dashboard');
});
