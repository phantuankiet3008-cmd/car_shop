<?php
use App\Http\Controllers\User\BaoDuong_controller;
use Illuminate\Support\Facades\Route;


// BẢO DƯỠNG XE
Route::get('/car_shop/baoduong', function () {
    return view('user.layouts.BaoDuong');
})->name('baoduong');
Route::get('/car_shop/baoduong', [BaoDuong_controller::class, 'trang_baoduong']);
Route::post('/car_shop/datlichbaoduong', [BaoDuong_controller::class, 'datlich_baoduong']);

// BẢO DƯỠNG ADMIN
Route::get('/trang_admin/baoduong', [QLBaoDuong_controller::class, 'index']);

// GÓI BẢO DƯỠNG
Route::get('/trang_admin/goibaoduong', [QLGoiBaoDuong_controller::class,'index']);
Route::get('/trang_admin/goibaoduong/them', function () {
    return view('admin.layouts.index_AD', [
        'key' => 'add_goi_bao_duong'
    ]);
});
Route::get('/trang_admin/goibaoduong/xoa/{id}', [QLGoiBaoDuong_controller::class,'xoa_goi']);
});