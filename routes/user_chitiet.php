<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\chitietxeController;
use App\Http\Controllers\User\danhsachsanphamController;
Route::prefix('user')->group(function () {

    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);

   Route::get('/car_shop/danhsachsanpham', [danhsachsanphamController::class, 'index']);
route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);
});