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
use App\Http\Controllers\User\TrangChuController;
use App\Http\Controllers\User\donhangController;
use App\Http\Controllers\User\DatCocController;
use App\Http\Controllers\User\VNPayController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;

// =========================================================
// 1. ROUTE CÔNG KHAI (KHÔNG CẦN ĐĂNG NHẬP)
// =========================================================
Route::prefix('user')->group(function () {
    Route::get('/car_shop/trangchu', [TrangChuController::class, 'trangchu'])->name('trangchu');
    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);
    Route::get('/car_shop/danhsachsanpham/{IDloai?}/{IDTH?}', [danhsachsanphamController::class, 'index'])->name('danhsach');

    // Auth (Đăng nhập, đăng ký)
    Route::get('/car_shop/dangnhap', function () { return view('user.layouts.DangNhap'); })->name('dangnhap');
    Route::post('/car_shop/dangnhap', [DangNhap_controller::class, 'dangnhap']);
    Route::get('/car_shop/dangky', function () { return view('user.layouts.DangKy'); })->name('dangky');
    Route::post('/car_shop/dangky', [DangKy_controller::class, 'dangky']);
    Route::get('/car_shop/dangxuat', function () { session()->flush(); return redirect()->route('trangchu'); })->name('dangxuat');

    // Quên mật khẩu & OTP
    Route::get('/car_shop/quenmk', function () { return view('user.layouts.QuenMK'); })->name('quenmk');
    Route::post('/car_shop/quenmk', [QuenMK_controller::class, 'quenmk']);
    Route::post('/car_shop/guiotp', [otp_controller::class, 'guiotp'])->name('gui.otp');
    Route::post('/car_shop/xacminhotp', [otp_controller::class, 'xacminhotp'])->name('xacminh.otp');
    Route::get('/car_shop/capnhatmk', [QuenMK_controller::class, 'formCapNhatMK'])->name('form.capnhatmk');
    Route::post('/car_shop/capnhatmk', [QuenMK_controller::class, 'capNhatMK'])->name('password.reset.process');
});

// =========================================================
// 2. ROUTE CẦN ĐĂNG NHẬP (USER.AUTH)
// =========================================================
Route::middleware('user.auth')->prefix('user')->group(function () {
    
    // Trang cá nhân & Profile
    Route::get('/car_shop/trangcanhan', [trangcanhanController::class, 'index'])->name('trang_ca_nhan');
    Route::get('/car_shop/profile', [profileController::class, 'index'])->name('profile');
    Route::post('/car_shop/profile/update', [profileController::class, 'update'])->name('profile.update');

    // Đơn hàng & Đặt cọc
    Route::get('/donhang', [donhangController::class, 'index'])->name('don-hang'); // Tên này dùng cho redirect
    Route::get('/car_shop/datcoc/{id}', [DatCocController::class, 'datcoc'])->name('datcoc');
    Route::post('/car_shop/tao-don', [DatCocController::class, 'taoDon'])->name('taoDon');

    // THANH TOÁN (CHECKOUT) - QUAN TRỌNG: CHỈ ĐỂ Ở ĐÂY
    Route::get('/car_shop/checkout/{id}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/car_shop/checkout/{id}', [CheckoutController::class, 'selectPayment'])->name('selectPayment');

    // VNPay
    Route::get('/car_shop/vnpay/redirect/{id}', [VNPayController::class, 'redirect'])->name('vnpay.redirect');
    Route::get('/car_shop/vnpay/return', [VNPayController::class, 'return'])->name('vnpay.return');
    
     // Stripe 
     Route::get('/stripe/checkout/{id}', [StripeController::class, 'checkout'])->name('stripe.checkout');
     Route::get('/stripe/success/{id}', [StripeController::class, 'success'])->name('stripe.success');
     Route::get('/stripe/cancel/{id}', [StripeController::class, 'cancel'])->name('stripe.cancel');
    // Lái thử
    Route::get('/car_shop/dangkilaithu/{id}', [dangkilaithuController::class, 'index']);
    Route::post('/car_shop/lay_gio_da_dat', [dangkilaithuController::class, 'layGioDaDat'])->name('dangkilaithu');
    Route::post('/car_shop/dat_lich_lai_thu', [dangkilaithuController::class, 'store']);
    Route::get('/car_shop/lich-lai-thu-cua-toi', [dangkilaithuController::class, 'lichCuaToi']);
});