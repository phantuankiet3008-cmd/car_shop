<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\TrangChuController;
use App\Http\Controllers\User\donhangController;

Route::get('/user/trangchu', [TrangChuController::class, 'index'])
    ->name('user.trangchu');

    Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/donhang', [donhangController::class, 'index'])->name('donhang');