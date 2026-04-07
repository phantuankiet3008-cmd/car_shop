<?php

use Illuminate\Support\Facades\Route;

// Import Controllers
use App\Http\Controllers\Admin\DangNhapADM_controller;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\LoaiXeController;
use App\Http\Controllers\Admin\ThuongHieuXeController;
use App\Http\Controllers\Admin\SanPhamController;
use App\Http\Controllers\Admin\KhachHangController;
use App\Http\Controllers\Admin\lichlaythuController;
use App\Http\Controllers\Admin\ThongKeController;
use App\Http\Controllers\Admin\QLBaoDuong_controller;
use App\Http\Controllers\Admin\QLGoiBaoDuong_controller;
use App\Http\Controllers\Admin\DonHang_Controller;
use App\Http\Controllers\Admin\NhanVien_controller;
use App\Http\Controllers\Admin\UuDaiController;
use App\Http\Controllers\User\BaoDuong_controller;

/*
|--------------------------------------------------------------------------
| USER ROUTES (Car Shop)
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('trang_admin')->group(function () {

    // ================= LOGIN & AUTH =================
    Route::get('DangNhapADM', [DangNhapADM_controller::class, 'showLogin'])->name('admin.login.form');
    Route::post('DangNhapADM', [DangNhapADM_controller::class, 'login'])->name('admin.login');
    Route::get('logout', [DangNhapADM_controller::class, 'logout'])->name('admin.logout');

    // ================= KHU VỰC CẦN ĐĂNG NHẬP (Middleware chung) =================
    Route::middleware(['check.session'])->group(function () {

        // Dashboard chung
        Route::get('', function () {
            return view('admin.layouts.index_AD', ['key' => 'dashboard']);
        })->name('admin.dashboard');

        // ===== NHÓM QUẢN TRỊ VIÊN CAO CẤP (Role 1 - Toàn quyền xóa & Nhân sự) =====
        Route::middleware(['role:1'])->group(function () {
            
            // Quản lý Nhân viên
            Route::resource('nhan_vien', NhanVien_controller::class)->except(['show']);
            Route::get('nhan_vien/tim', [NhanVien_controller::class, 'index']);

            // Các route xóa (Destroy) đặc quyền của Admin
            Route::prefix('san_pham')->group(function () {
                Route::delete('xoa_mau/{id}', [SanPhamController::class, 'destroyMau']);
                Route::get('xoa/{id}', [SanPhamController::class, 'destroy']);
            });
            Route::prefix('loai_xe')->group(function (){
                Route::get('xoa/{id}', [LoaiXeController::class, 'destroy']);
                Route::get('them', [LoaiXeController::class, 'create']);
                Route::post('them', [LoaiXeController::class, 'store']);
                Route::get('sua/{id}', [LoaiXeController::class, 'edit']);
                Route::post('sua/{id}', [LoaiXeController::class, 'update']);


            });
             Route::prefix('thuong_hieu')->group(function (){
                 Route::get('xoa/{id}', [ThuongHieuXeController::class, 'destroy']);
                 Route::get('them', [ThuongHieuXeController::class, 'create']);
                Route::post('them', [ThuongHieuXeController::class, 'store']);
                Route::get('sua/{id}', [ThuongHieuXeController::class, 'edit']);
                Route::post('sua/{id}', [ThuongHieuXeController::class, 'update']);

            });
            Route::prefix('khach_hang')->group(function (){
                Route::get('xoa/{id}', [KhachHangController::class, 'destroy']);

            });
            Route::prefix('lai_thu')->group(function (){
                Route::get('xoa/{id}', [lichlaythuController::class, 'xoa']);

            });
              Route::prefix('don_hang')->group(function (){
               Route::delete('xoa/{id}', [DonHang_Controller::class, 'destroy']);

            });
            Route::prefix('baoduong')->group(function (){
              Route::get('xoa/{id}', [QLBaoDuong_controller::class, 'destroy']);

            });
        });

        // ===== NHÓM QUẢN TRỊ & KẾ TOÁN (Role 1, 3 - Bao gồm Thống kê) =====
        Route::middleware(['role:1,3'])->group(function () {
            // Thống kê & Kiểm kê
            Route::prefix('kiem_ke')->group(function () {
                Route::get('khunggio-theongay', [ThongKeController::class, 'khungGioTheoNgay']);
                Route::get('bao-duong-theongay', [ThongKeController::class, 'baoDuongTheoNgay']);
                Route::get('{tab?}', [ThongKeController::class, 'index']);
            });

            // Kế toán cũng cần xem Đơn hàng và Lịch lái thử
            Route::get('don_hang', [DonHang_Controller::class, 'index'])->name('admin.donhang.index');
            Route::get('lai_thu', [lichlaythuController::class, 'index']);
        });

        // ===== NHÓM KINH DOANH / BÁN HÀNG (Role 1, 2) =====
        Route::middleware(['role:1,2'])->group(function () {

    // ================= LOẠI XE =================
    Route::prefix('loai_xe')->group(function (){
        Route::get('', [LoaiXeController::class, 'index']);
        Route::get('them', [LoaiXeController::class, 'create']);
        Route::post('them', [LoaiXeController::class, 'store']);
        Route::get('sua/{id}', [LoaiXeController::class, 'edit']);
        Route::post('sua/{id}', [LoaiXeController::class, 'update']);
    });

    // ================= THƯƠNG HIỆU =================
    Route::prefix('thuong_hieu')->group(function (){
        Route::get('', [ThuongHieuXeController::class, 'index']);
        Route::get('them', [ThuongHieuXeController::class, 'create']);
        Route::post('them', [ThuongHieuXeController::class, 'store']);
        Route::get('sua/{id}', [ThuongHieuXeController::class, 'edit']);
        Route::post('sua/{id}', [ThuongHieuXeController::class, 'update']);
    });

    // ================= SẢN PHẨM =================
    Route::prefix('san_pham')->group(function (){
        Route::get('', [SanPhamController::class, 'index']);
        Route::get('them', [SanPhamController::class, 'create']);
        Route::post('them', [SanPhamController::class, 'store']);
        Route::get('sua/{id}', [SanPhamController::class, 'edit']);
        Route::post('sua/{id}', [SanPhamController::class, 'update']);
    });

    // ================= KHÁCH HÀNG =================
    Route::prefix('khach_hang')->group(function (){
        Route::get('', [KhachHangController::class, 'index']);
        Route::get('them', [KhachHangController::class, 'create']);
        Route::post('them', [KhachHangController::class, 'store']);
        Route::get('sua/{id}', [KhachHangController::class, 'edit']);
        Route::post('sua/{id}', [KhachHangController::class, 'update']);
        Route::get('tim/{keyword}', [KhachHangController::class, 'search']);
    });

    // ================= ƯU ĐÃI =================
    Route::prefix('uu_dai')->group(function (){
        Route::get('', [UuDaiController::class, 'index']);
        Route::get('them', [UuDaiController::class, 'create']);
        Route::post('them', [UuDaiController::class, 'store']);
    });

    // ================= XE ƯU ĐÃI =================
    Route::prefix('xe_uu_dai')->group(function (){
        Route::get('', [UuDaiController::class, 'indexXeUuDai']);
        Route::get('them', [UuDaiController::class, 'createXeUuDai']);
        Route::post('them', [UuDaiController::class, 'storeXeUuDai']);
        Route::get('xoa/{id_xe}/{id_uudai}', [UuDaiController::class, 'destroyXeUuDai']);
    });

    // ================= ĐƠN HÀNG =================
    Route::prefix('don_hang')->group(function (){
        Route::get('', [DonHang_Controller::class, 'index'])->name('admin.donhang.index');
        Route::get('them', [DonHang_Controller::class, 'create']);
        Route::post('them', [DonHang_Controller::class, 'store'])->name('admin.donhang.store');
        Route::get('sua/{id}', [DonHang_Controller::class, 'edit']);
        Route::post('cap-nhat/{id}', [DonHang_Controller::class, 'update']);
       
});
    // ================= LÁI THỬ =================
    Route::prefix('lai_thu')->group(function (){
        Route::get('', [lichlaythuController::class, 'index']);
        Route::get('cap-nhat/{id}/{trangThai}', [lichlaythuController::class, 'capNhatTrangThai']);
    });

});
        // ===== NHÓM KỸ THUẬT / BẢO DƯỠNG (Role 1, 4) =====
        Route::middleware(['role:1,4'])->group(function () {
            // Quản lý Bảo dưỡng
            Route::prefix('baoduong')->group(function () {
                Route::get('', [QLBaoDuong_controller::class, 'index']);
                Route::get('sua/{id}', [QLBaoDuong_controller::class, 'edit']);
                Route::post('update/{id}', [QLBaoDuong_controller::class, 'update']);
            });

            // Quản lý Gói bảo dưỡng
            Route::prefix('goibaoduong')->group(function () {
                Route::get('', [QLGoiBaoDuong_controller::class, 'index'])->name('goibaoduong.index');
                Route::get('them', function () {
                    return view('admin.layouts.index_AD', ['key' => 'add_goi_bao_duong']);
                });
                Route::post('them', [QLGoiBaoDuong_controller::class, 'them_goi']);
                Route::get('sua/{id}', [QLGoiBaoDuong_controller::class, 'edit'])->name('goibaoduong.edit');
                Route::post('sua/{id}', [QLGoiBaoDuong_controller::class, 'update'])->name('goibaoduong.update');
                Route::get('xoa/{id}', [QLGoiBaoDuong_controller::class, 'xoa_goi']);
            });
        });

        // Các API dùng chung cho Dropdown động
         Route::get('api/get-san-pham', [DonHang_Controller::class, 'getSanPhamByFilter']);
        Route::get('api/get-mau-xe', [DonHang_Controller::class, 'getMauBySanPham']);
    });
       

    }); 
