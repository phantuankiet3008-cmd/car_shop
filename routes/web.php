<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DangNhapADM_controller;
use App\Http\Controllers\Admin\LoaiXeController;
use App\Http\Controllers\Admin\ThuongHieuXeController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\KhachHangController;
use App\Http\Controllers\Admin\lichlaythuController;
use App\Http\Controllers\Admin\QLBaoDuong_controller;
use App\Http\Controllers\Admin\QLGoiBaoDuong_controller;
use App\Http\Controllers\Admin\NhanVien_controller;

Route::prefix('trang_admin')->group(function () {

    // ================= LOGIN =================
    Route::get('DangNhapADM', [DangNhapADM_controller::class, 'showLogin'])
        ->name('admin.login.form');
    Route::post('DangNhapADM', [DangNhapADM_controller::class, 'login'])
        ->name('admin.login');

    Route::get('logout', [DangNhapADM_controller::class, 'logout'])
        ->name('admin.logout');


    // ================= CẦN LOGIN =================
    Route::middleware(['check.session'])->group(function () {

        // Dashboard
        Route::get('', function () {
            return view('admin.layouts.index_AD', ['key' => 'dashboard']);
        })->name('admin.dashboard');


        // ===== ADMIN (role 1) =====
        Route::middleware(['role:1'])->group(function () {

            Route::prefix('loai_xe')->group(function () {
                Route::get('', [LoaiXeController::class, 'index']);
                Route::get('them', [LoaiXeController::class, 'create']);
                Route::post('them', [LoaiXeController::class, 'store']);
                Route::get('sua/{id}', [LoaiXeController::class, 'edit']);
                Route::post('sua/{id}', [LoaiXeController::class, 'update']);
                Route::get('xoa/{id}', [LoaiXeController::class, 'destroy']);
            });

            Route::prefix('thuong_hieu')->group(function () {
                Route::get('', [ThuongHieuXeController::class, 'index']);
                Route::get('them', [ThuongHieuXeController::class, 'create']);
                Route::post('them', [ThuongHieuXeController::class, 'store']);
                Route::get('sua/{id}', [ThuongHieuXeController::class, 'edit']);
                Route::post('sua/{id}', [ThuongHieuXeController::class, 'update']);
                Route::get('xoa/{id}', [ThuongHieuXeController::class, 'destroy']);
            });

            Route::prefix('nhan_vien')->group(function () {
                Route::get('', [NhanVien_controller::class, 'index']);
                Route::get('tim', [NhanVien_controller::class, 'index']);
                Route::get('them', [NhanVien_controller::class, 'create']);
                Route::post('them', [NhanVien_controller::class, 'store']);
                Route::get('sua/{id}', [NhanVien_controller::class, 'edit']);
                Route::post('sua/{id}', [NhanVien_controller::class, 'update']);
                Route::get('xoa/{id}', [NhanVien_controller::class, 'destroy']);
            });
        });


        // ===== NHÂN VIÊN (role 1,2) =====
        Route::middleware(['role:1,2'])->group(function () {

            Route::get('san_pham', [SanPhamController::class, 'index']);

            Route::prefix('khach_hang')->group(function () {
                Route::get('', [KhachHangController::class, 'index']);
                Route::get('tim/{keyword}', [KhachHangController::class, 'search']);
                Route::get('them', [KhachHangController::class, 'create']);
                Route::post('them', [KhachHangController::class, 'store']);
                Route::get('sua/{id}', [KhachHangController::class, 'edit']);
                Route::post('sua/{id}', [KhachHangController::class, 'update']);
            });
        });


        // ===== KẾ TOÁN (role 1,3) =====
        Route::middleware(['role:1,3'])->group(function () {

            Route::prefix('lai_thu')->group(function () {
                Route::get('', [lichlaythuController::class, 'index']);
                Route::get('cap-nhat/{id}/{trangThai}', [lichlaythuController::class, 'capNhatTrangThai']);
                Route::get('xoa/{id}', [lichlaythuController::class, 'xoa']);
            });
        });


        // ===== KỸ THUẬT (role 1,4) =====
        Route::middleware(['role:1,4'])->group(function () {

            Route::get('baoduong', [QLBaoDuong_controller::class, 'index']);

            Route::prefix('goibaoduong')->group(function () {
                Route::get('', [QLGoiBaoDuong_controller::class, 'index']);
                Route::get('them', function () {
                    return view('admin.layouts.index_AD', ['key' => 'add_goi_bao_duong']);
                });
                Route::post('them', [QLGoiBaoDuong_controller::class, 'them_goi']);
                Route::get('xoa/{id}', [QLGoiBaoDuong_controller::class, 'xoa_goi']);
            });
        });

    });
});