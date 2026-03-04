<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\chitietxeController;
use App\Http\Controllers\User\trangcanhanController;
use App\Http\Controllers\User\profileController;
use App\Http\Controllers\User\danhsachsanphamController;
Route::prefix('user')->group(function () {

    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);

    Route::get('/car_shop/trangcanhan', [trangcanhanController::class, 'index'])->name('trang_ca_nhan'); 
  
    Route::get('/car_shop/profile', [profileController::class, 'index'])->name('profile');
    Route::post('/car_shop/profile/update', [profileController::class, 'update'])->name('profile.update');
   Route::get('/car_shop/danhsachsanpham', [danhsachsanphamController::class, 'index']);
Route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);
});