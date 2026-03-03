<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\chitietxeController;
use App\Http\Controllers\User\danhsachsanphamController;
use App\Http\Controllers\User\dangkilaithuController;
Route::prefix('user')->group(function () {
// Chi tiết xe
    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);


// Danh sách sản phẩm
     Route::get('/car_shop/danhsachsanpham', [danhsachsanphamController::class, 'index']);
    Route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);


// Đăng ký lái thử
     
    Route::get('/car_shop/dangkilaithu/{id}', [dangkilaithuController::class, 'index']);
    Route::post('/car_shop/dangkilaithu', [dangkilaithuController::class, 'dangKyLaiThu'])
        ->name('dangkilaithu');

});    