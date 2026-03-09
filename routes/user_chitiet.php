<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\chitietxeController;
use App\Http\Controllers\User\trangcanhanController;
use App\Http\Controllers\User\profileController;
use App\Http\Controllers\User\danhsachsanphamController;
use App\Http\Controllers\User\dangkilaithuController;
use App\Http\Controllers\User\DangNhap_controller;
use App\Http\Controllers\User\DangKy_controller;
use App\Http\Controllers\User\QuenMK_controller;
use App\Http\Controllers\User\otp_controller;
Route::prefix('user')->group(function () {
// Chi tiết xe
    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);

    Route::get('/car_shop/trangcanhan', [trangcanhanController::class, 'index'])->name('trang_ca_nhan'); 
  
    Route::get('/car_shop/profile', [profileController::class, 'index'])->name('profile');
    Route::post('/car_shop/profile/update', [profileController::class, 'update'])->name('profile.update');
   Route::get('/car_shop/danhsachsanpham', [danhsachsanphamController::class, 'index']);
Route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);
});


// Danh sách sản phẩm
     Route::get('/car_shop/danhsachsanpham', [danhsachsanphamController::class, 'index']);
    Route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);


// Đăng ký lái thử
     
    Route::get('/car_shop/dangkilaithu/{id}', [dangkilaithuController::class, 'index']);
    Route::post('/car_shop/lay_gio_da_dat', [dangkilaithuController::class, 'layGioDaDat'])
        ->name('dangkilaithu');
    


          Route::get('/car_shop/danhsachsanpham', [danhsachsanphamController::class, 'index']);
    Route::get('/car_shop/danhsachsanpham/{IDloai}/{IDTH}',[danhsachsanphamController::class,'index']);

/// ĐĂNG NHẬP KH
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
  Route::middleware('user.auth')->group(function () {
    Route::post('/car_shop/dat_lich_lai_thu', [dangkilaithuController::class, 'store']);
    Route::get('/car_shop/lich-lai-thu-cua-toi', [dangkilaithuController::class, 'lichCuaToi']);

  });
Route::get('/car_shop/trangcanhan', [trangcanhanController::class, 'index']);

Route::get('/car_shop/profile', [profileController::class, 'index'])
    ->name('profile');

Route::post('/car_shop/profile/update', [profileController::class, 'update'])
    ->name('profile.update');