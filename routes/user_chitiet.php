<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\chitietxeController;

Route::prefix('user')->group(function () {

    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);

   








Route::get('/trangchu', function () {
    return view('user.layouts.user_index');
});
         

    });
