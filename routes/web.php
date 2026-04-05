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
use Illuminate\Support\Facades\Route;
use App\Services\QL;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\User\BaoDuong_controller;
use App\Http\Controllers\Admin\QLBaoDuong_controller;
use App\Http\Controllers\Admin\QLGoiBaoDuong_controller;
use App\Http\Controllers\Admin\DonHang_Controller;
use App\Http\Controllers\Admin\NhanVien_controller;
use App\Http\Controllers\Admin\UuDaiController;
use App\Http\Controllers\Admin\DonHang_Controller;
use App\Http\Controllers\User\BaoDuong_controller as UserBaoDuongController;


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('trang_admin')->group(function () {

    // ================= LOGIN =================
    // Sử dụng AdminAuthController để đồng bộ với các chức năng mới
    Route::get('DangNhapADM', [DangNhapADM_controller::class, 'showLogin'])->name('admin.login.form');
    Route::post('DangNhapADM', [DangNhapADM_controller::class, 'login'])->name('admin.login');
    Route::get('logout', [DangNhapADM_controller::class, 'logout'])->name('admin.logout');


    // ================= KHU VỰC CẦN ĐĂNG NHẬP =================
    Route::middleware(['check.session'])->group(function () {

        // Dashboard chung
        Route::get('', function () {
            return view('admin.layouts.index_AD', ['key' => 'dashboard']);
        })->name('admin.dashboard');


        // ===== NHÓM QUẢN TRỊ VIÊN (Role 1) =====
        Route::middleware(['role:1'])->group(function () {
            
            // Loại xe
            Route::prefix('loai_xe')->group(function () {
                Route::get('', [LoaiXeController::class, 'index']);
                Route::get('them', [LoaiXeController::class, 'create']);
                Route::post('them', [LoaiXeController::class, 'store']);
                Route::get('sua/{id}', [LoaiXeController::class, 'edit']);
                Route::post('sua/{id}', [LoaiXeController::class, 'update']);
                Route::get('xoa/{id}', [LoaiXeController::class, 'destroy']);
            });

            // Thương hiệu
            Route::prefix('thuong_hieu')->group(function () {
                Route::get('', [ThuongHieuXeController::class, 'index']);
                Route::get('them', [ThuongHieuXeController::class, 'create']);
                Route::post('them', [ThuongHieuXeController::class, 'store']);
                Route::get('sua/{id}', [ThuongHieuXeController::class, 'edit']);
                Route::post('sua/{id}', [ThuongHieuXeController::class, 'update']);
                Route::get('xoa/{id}', [ThuongHieuXeController::class, 'destroy']);
            });
// Nhân viên
            Route::prefix('nhan_vien')->group(function () {
                Route::get('', [NhanVien_controller::class, 'index']);
                Route::get('tim', [NhanVien_controller::class, 'index']); // Giữ lại route tìm kiếm
                Route::get('them', [NhanVien_controller::class, 'create']);
                Route::post('them', [NhanVien_controller::class, 'store']);
                Route::get('sua/{id}', [NhanVien_controller::class, 'edit']);
                Route::post('sua/{id}', [NhanVien_controller::class, 'update']);
                Route::get('xoa/{id}', [NhanVien_controller::class, 'destroy']);
            });

            // Ưu đãi
            Route::prefix('uu_dai')->group(function () {
                Route::get('', [UuDaiController::class, 'index']);
                Route::get('them', [UuDaiController::class, 'create']);
                Route::post('them', [UuDaiController::class, 'store']);
                Route::get('xoa/{id}', [UuDaiController::class, 'destroy']);
            });

            Route::prefix('xe_uu_dai')->group(function () {
                Route::get('', [UuDaiController::class, 'indexXeUuDai']);
                Route::get('them', [UuDaiController::class, 'createXeUuDai']);
                Route::post('them', [UuDaiController::class, 'storeXeUuDai']);
                Route::get('xoa/{id_xe}/{id_uudai}', [UuDaiController::class, 'destroyXeUuDai']);
            });
        });


        // ===== NHÓM NHÂN VIÊN / BÁN HÀNG (Role 1,2) =====
        Route::middleware(['role:1,2'])->group(function () {
            
            // Sản phẩm (Xe)
            Route::prefix('san_pham')->group(function () {
                Route::get('', [SanPhamController::class, 'index']);
                Route::get('them', [SanPhamController::class, 'create']);
                Route::post('them', [SanPhamController::class, 'store']);
                Route::get('sua/{id}', [SanPhamController::class, 'edit']);
                Route::post('sua/{id}', [SanPhamController::class, 'update']);
                Route::delete('xoa_mau/{id}', [SanPhamController::class, 'destroyMau']);
                Route::get('xoa/{id}', [SanPhamController::class, 'destroy']);
            });

            // Khách hàng
            Route::prefix('khach_hang')->group(function () {
                Route::get('', [KhachHangController::class, 'index']);
                Route::get('tim/{keyword}', [KhachHangController::class, 'search']);
                Route::get('them', [KhachHangController::class, 'create']);
                Route::post('them', [KhachHangController::class, 'store']);
                Route::get('sua/{id}', [KhachHangController::class, 'edit']);
                Route::post('sua/{id}', [KhachHangController::class, 'update']);
                Route::get('xoa/{id}', [KhachHangController::class, 'destroy']);
            });

            // Đơn hàng
            Route::prefix('don_hang')->group(function () {
                Route::get('/', [DonHang_Controller::class, 'index'])->name('admin.donhang.index');
                Route::get('/them', [DonHang_Controller::class, 'create']);
                Route::post('/them', [DonHang_Controller::class, 'store'])->name('admin.donhang.store');
                Route::get('/sua/{id}', [DonHang_Controller::class, 'edit']);
                Route::post('/cap-nhat/{id}', [DonHang_Controller::class, 'update']);
                Route::delete('/xoa/{id}', [DonHang_Controller::class, 'destroy']);
                Route::get('/api/get-san-pham', [DonHang_Controller::class, 'getSanPhamByFilter']);
                Route::get('/api/get-mau-xe', [DonHang_Controller::class, 'getMauBySanPham']);
            });
        });


        // ===== NHÓM KẾ TOÁN / LÁI THỬ (Role 1,3) =====
        Route::middleware(['role:1,3'])->group(function () {
            Route::prefix('lai_thu')->group(function () {
                Route::get('', [lichlaythuController::class, 'index']);
                Route::get('cap-nhat/{id}/{trangThai}', [lichlaythuController::class, 'capNhatTrangThai']);
                Route::get('xoa/{id}', [lichlaythuController::class, 'xoa']);
            });
        });


        // ===== NHÓM KỸ THUẬT / BẢO DƯỠNG (Role 1,4) =====
        Route::middleware(['role:1,4'])->group(function () {

            // BẢO DƯỠNG
            Route::prefix('baoduong')->group(function () {

                Route::get('', [QLBaoDuong_controller::class, 'index']);
        
                Route::get('sua/{id}', [QLBaoDuong_controller::class, 'edit']);
        
                Route::post('update/{id}', [QLBaoDuong_controller::class, 'update']);
        
                Route::get('xoa/{id}', [QLBaoDuong_controller::class, 'destroy']);
            });


            // GÓI BẢO DƯỠNG
            Route::prefix('goibaoduong')->group(function () {
                Route::get('', [QLGoiBaoDuong_controller::class, 'index'])
                ->name('goibaoduong.index');

                Route::get('them', function () {
                    return view('admin.layouts.index_AD', ['key' => 'add_goi_bao_duong']);
                });
                Route::post('them', [QLGoiBaoDuong_controller::class, 'them_goi']);

                Route::get('sua/{id}', [QLGoiBaoDuong_controller::class, 'edit'])
                ->name('goibaoduong.edit');
                Route::post('sua/{id}', [QLGoiBaoDuong_controller::class, 'update'])
                ->name('goibaoduong.update');
                
                Route::get('xoa/{id}', [QLGoiBaoDuong_controller::class, 'xoa_goi']);
            });
        });
Route::post('/trang_admin/DangNhapADM', [AdminAuthController::class, 'login'])
    ->name('admin.login');

// ====== KHU VỰC ADMIN ======
// Route::middleware('admin.auth')->group(function () {

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
Route :: delete('/trang_admin/san_pham/xoa_mau/{id}', [SanPhamController::class, 'destroyMau']);
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


   // ===== LỊCH LÁI THỬ =====
   Route::get('/trang_admin/lai_thu', [lichLayThuController::class, 'index']);
Route::get('/trang_admin/lai_thu/cap-nhat/{id}/{trangThai}', [lichLayThuController::class, 'capNhatTrangThai']);

Route::get('/trang_admin/lai_thu/xoa/{id}', [lichLayThuController::class, 'xoa']);
// ====== đơn hàng ====
   // ====== ĐƠN HÀNG ======
Route::prefix('trang_admin/don_hang')->group(function () {
    Route::get('/', [DonHang_Controller::class, 'index'])->name('admin.donhang.index');          // Danh sách & Lọc
    Route::get('/them', [DonHang_Controller::class, 'create']);    // Form thêm mới
    Route::post('/them', [DonHang_Controller::class, 'store'])->name('admin.donhang.store');     // Lưu mới
    Route::get('/sua/{id}', [DonHang_Controller::class, 'edit']);   // Form sửa
    Route::post('/cap-nhat/{id}', [DonHang_Controller::class, 'update']); // Cập nhật
    Route::delete('/xoa/{id}', [DonHang_Controller::class, 'destroy']);   // Xóa đơn hàng
});

// Các API cho Dropdown động (giữ nguyên của bạn)
Route::get('/api/get-san-pham', [DonHang_Controller::class, 'getSanPhamByFilter']);
Route::get('/api/get-mau-xe', [DonHang_Controller::class, 'getMauBySanPham']);


 //  });

   
   


































































































































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

});

});


    Route::get('/trang_admin/goibaoduong/xoa/{id}', [QLGoiBaoDuong_controller::class,'xoa_goi']);
   
  


  // ===== KIỂM KÊ TIÊU DÙNG =====//
    Route::get('/trang_admin/kiem_ke/khunggio-theongay', [ThongKeController::class, 'khungGioTheoNgay']);
    Route::get('/trang_admin/kiem_ke/bao-duong-theongay', [ThongKeController::class, 'baoDuongTheoNgay']);
    Route::get('/trang_admin/kiem_ke/{tab?}', [ThongKeController::class, 'index']);































































































































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
    Route::post('/trang_admin/goibaoduong/them', [QLGoiBaoDuong_controller::class, 'them_goi']);

    Route::get('/trang_admin/goibaoduong/xoa/{id}', [QLGoiBaoDuong_controller::class,'xoa_goi']);


