<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\{
    TrangChuController,
    chitietxeController,
    danhsachsanphamController,
    DangNhap_controller,
    DangKy_controller,
    QuenMK_controller,
    otp_controller,
    trangcanhanController,
    profileController,
    dangkilaithuController,
    DatCocController,
    CheckoutController,
    VNPayController,
    MoMoController,
    BaoDuong_controller,
    donhangController
};


// =========================================================
// 1. ROUTE CÔNG KHAI (KHÔNG CẦN ĐĂNG NHẬP)
// =========================================================
Route::prefix('user')->group(function () {
    Route::get('/car_shop/trangchu', [TrangChuController::class, 'trangchu'])->name('trangchu');
    Route::get('/car_shop/chitietxe/{id}', [chitietxeController::class, 'index']);
    Route::get('/car_shop/danhsachsanpham/{IDloai?}/{IDTH?}', [danhsachsanphamController::class, 'index'])->name('danhsach');

    // Auth (Giữ nguyên name cũ)
    Route::get('/car_shop/dangnhap', function () { return view('user.layouts.DangNhap'); })->name('dangnhap');
    Route::post('/car_shop/dangnhap', [DangNhap_controller::class, 'dangnhap']);
    
    Route::get('/car_shop/dangky', function () { return view('user.layouts.DangKy'); })->name('dangky');
    Route::post('/car_shop/dangky', [DangKy_controller::class, 'dangky']);
    
    Route::get('/car_shop/dangxuat', function () { session()->flush(); return redirect()->route('trangchu'); })->name('dangxuat');

    // Quên mật khẩu & OTP
    Route::get('/car_shop/quenmk', function () { return view('user.layouts.QuenMK'); })->name('quenmk');
    Route::post('/car_shop/quenmk', [QuenMK_controller::class, 'quenmk']);
    Route::post('/car_shop/guiotp', [otp_controller::class, 'guiotp'])->name('gui.otp');
    Route::post('/car_shop/xacminhotp', [otp_controller::class, 'xacminh.otp']);
    
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
    Route::get('/donhang', [donhangController::class, 'index'])->name('don-hang'); 
    Route::get('/car_shop/datcoc/{id}', [DatCocController::class, 'datcoc']); 
    Route::post('/car_shop/datcoc/', [DatCocController::class, 'datcoc'])->name('datcoc');
    Route::post('/car_shop/tao-don', [DatCocController::class, 'taoDon'])->name('taoDon');

    // Thanh toán
    Route::get('/car_shop/checkout/{id}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/car_shop/checkout/{id}', [CheckoutController::class, 'selectPayment'])->name('selectPayment');

    // VNPay & MoMo
    Route::get('/car_shop/vnpay/redirect/{id}', [VNPayController::class, 'redirect'])->name('vnpay.redirect');
    Route::get('/car_shop/vnpay/return', [VNPayController::class, 'return'])->name('vnpay.return');

    
     // Stripe 
     Route::get('/stripe/checkout/{id}', [StripeController::class, 'checkout'])->name('stripe.checkout');
     Route::get('/stripe/success/{id}', [StripeController::class, 'success'])->name('stripe.success');
     Route::get('/stripe/cancel/{id}', [StripeController::class, 'cancel'])->name('stripe.cancel');
    // Lái thử
    Route::get('/car_shop/dangkilaithu/{id}', [dangkilaithuController::class, 'index']);
    Route::get('/car_shop/momo/redirect/{id}', [MoMoController::class, 'redirect'])->name('momo.redirect');
    Route::get('/car_shop/momo/return', [MoMoController::class, 'return'])->name('momo.return');

    // Lái thử (Giữ nguyên name dangkilaithu và datlaithu)
    Route::get('/car_shop/dangkilaithu/{id}', [dangkilaithuController::class, 'index'])->name('datlaithu');
    Route::post('/car_shop/lay_gio_da_dat', [dangkilaithuController::class, 'layGioDaDat'])->name('dangkilaithu');
    Route::post('/car_shop/dat_lich_lai_thu', [dangkilaithuController::class, 'store']);
    Route::get('/car_shop/lich-lai-thu-cua-toi', [dangkilaithuController::class, 'lichCuaToi']);

    // BẢO DƯỠNG XE
    Route::get('/car_shop/datlichbaoduong', [BaoDuong_controller::class, 'trang_baoduong'])->name('datlichbaoduong');
    Route::post('/car_shop/dat_bao_duong', [BaoDuong_controller::class, 'datlich_BaoDuong']);

});