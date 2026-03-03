<?php


use App\Http\Controllers\User\DangNhap_controller;
use App\Http\Controllers\User\DangKy_controller;
use App\Http\Controllers\User\QuenMK_controller;
use App\Http\Controllers\User\otp_controller;

use Illuminate\Support\Facades\Route;

// ĐANG NHẬP KH
Route::get('/car_shop/dangnhap', function () {
    return view('user.layouts.DangNhap');
})->name('dangnhap');
Route::post('/car_shop/dangnhap', [DangNhap_controller::class, 'dangnhap']);

// ĐĂNG KÝ KH
Route::get('/car_shop/dangky', function () {
    return view('user.layouts.DangKy');
})->name('dangky');
Route::post('/car_shop/dangky', [DangKy_controller::class, 'dangky']);

// QUÊN MẬT KHẨU
Route::get('/car_shop/quenmk', function () {
    return view('user.layouts.QuenMK');
})->name('quenmk');
Route::post('/car_shop/quenmk', [QuenMK_controller::class, 'quenmk']);


// OTP
Route::post('/car_shop/guiotp', 
    [otp_controller::class, 'guiotp'])
    ->name('gui.otp');

Route::post('/car_shop/xacminhotp', 
    [otp_controller::class, 'xacminhotp'])
    ->name('xacminh.otp');

// CẬP NHẬT MẬT KHẨU
Route::get('/car_shop/capnhatmk', 
    [QuenMK_controller::class, 'formCapNhatMK'])
    ->name('form.capnhatmk');

Route::post('/car_shop/capnhatmk', 
    [QuenMK_controller::class, 'capNhatMK'])
    ->name('password.reset.process');