<?php

use App\Http\Controllers\Admin\LoaiXeController;
use App\Http\Controllers\Admin\ThuongHieuXeController;
use App\Http\Controllers\Admin\UuDaiController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\KhachHangController;
use Illuminate\Support\Facades\Route;
use App\Services\QL;
use App\Http\Controllers\AdminAuthController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

// ====== ĐĂNG NHẬP ADMIN ======
Route::get('/trang_admin/DangNhapADM', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login.form');

Route::post('/trang_admin/DangNhapADM', [AdminAuthController::class, 'login'])
    ->name('admin.login');

// ====== KHU VỰC ADMIN ======
Route::middleware('admin.auth')->group(function () {

    // ===== DASHBOARD =====
    Route::get('/trang_admin', function () {
        return view('admin.layouts.index_AD', [
            'key' => 'dashboard'
        ]);
    });

    // ===== LOẠI XE =====
    Route ::get('/trang_admin/loai_xe', [LoaiXeController::class, 'index']);
    Route::get('/trang_admin/loai_xe/them', [LoaiXeController::class, 'create']);
    Route::post('/trang_admin/loai_xe/them', [LoaiXeController::class, 'store']);
    Route::get('/trang_admin/loai_xe/sua/{id}', [LoaiXeController::class, 'edit']);
    Route::post('/trang_admin/loai_xe/sua/{id}', [LoaiXeController::class, 'update']);
    Route::get('/trang_admin/loai_xe/xoa/{id}', [LoaiXeController::class, 'destroy']);
   


    // ===== THƯƠNG HIỆU XE =====
    Route ::get('/trang_admin/thuong_hieu', [ThuongHieuXeController::class, 'index']);
    Route::get('/trang_admin/thuong_hieu/them', [ThuongHieuXeController::class, 'create']);
    Route::post('/trang_admin/thuong_hieu/them', [ThuongHieuXeController::class, 'store']);
    Route::get('/trang_admin/thuong_hieu/sua/{id}', [ThuongHieuXeController::class, 'edit']);
    Route::post('/trang_admin/thuong_hieu/sua/{id}', [ThuongHieuXeController::class, 'update']);
    Route::get('/trang_admin/thuong_hieu/xoa/{id}', [ThuongHieuXeController::class, 'destroy']);

    // ===== XE =====
    Route :: get('/trang_admin/san_pham', [SanPhamController::class, 'index']);
    Route :: get('/trang_admin/san_pham/them', [SanPhamController::class, 'create']);
    Route :: post('/trang_admin/san_pham/them', [SanPhamController::class, 'store']);
    Route :: get('/trang_admin/san_pham/sua/{id}', [SanPhamController::class, 'edit']);
    Route :: post('/trang_admin/san_pham/sua/{id}', [SanPhamController::class, 'update']);
    Route :: get('/trang_admin/san_pham/xoa/{id}', [SanPhamController::class, 'destroy']);
    //===== khách hàng =====
    Route :: get('/trang_admin/khach_hang',[KhachHangController::class,'index']);
    Route :: get('/trang_admin/khach_hang/tim/{keyword}',[KhachHangController::class,'search']);
    Route :: get('/trang_admin/khach_hang/them',[KhachHangController::class,'create']);
    Route :: post('/trang_admin/khach_hang/them',[KhachHangController::class,'store']);
    Route :: get('/trang_admin/khach_hang/sua/{id}',[KhachHangController::class,'edit']);
    Route :: post('/trang_admin/khach_hang/sua/{id}',[KhachHangController::class,'update']);
    Route :: get('/trang_admin/khach_hang/xoa/{id}',[KhachHangController::class,'destroy']);
   //===== ưu đãi =====
   Route :: get('/trang_admin/uu_dai',[UuDaiController::class,'index']);
   Route :: get('/trang_admin/uu_dai/them',[UuDaiController::class,'create']);
   Route :: post('/trang_admin/uu_dai/them',[UuDaiController::class,'store']);
   Route :: get('/trang_admin/uu_dai/xoa/{id}',[UuDaiController::class,'destroy']);
   Route :: get('/trang_admin/xe_uu_dai',[UuDaiController::class,'indexXeUuDai']);
    Route :: get('/trang_admin/xe_uu_dai/them',[UuDaiController::class,'createXeUuDai']);
    Route :: post('/trang_admin/xe_uu_dai/them',[UuDaiController::class,'storeXeUuDai']);
    Route :: get('/trang_admin/uu_dai_xe/xoa/{id_xe}/{id_uudai}',[UuDaiController::class,'destroyXeUuDai']);
   
});
// Khi người dùng gõ /san-pham, nó sẽ gọi hàm index của controller
