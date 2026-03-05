<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product;
use App\Services\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class DangkilaithuController extends Controller
{
    // ===== 1. Load trang =====
    public function index($id_Xe_Mau)
{
    $sp = new Product();
    $id_Xe_Mau = (int)$id_Xe_Mau;

    // ===== 1. Lấy thông tin xe theo id_Xe_Mau =====
    $thongTinXe = $sp->getThongTinXeTheoXeMau($id_Xe_Mau);

    if (!$thongTinXe) {
        abort(404, 'Không tìm thấy xe.');
    }

    // ===== 2. Lấy khung giờ =====
    $kg = [];
    $result_khung = $sp->getKhungGio();

    if ($result_khung) {
        while ($row = $result_khung->fetch_assoc()) {
            $kg[] = $row;
        }
    }

    return view('user.layouts.DangKiLaiThu', [
        'thongTinXe' => (object)$thongTinXe,
        'khungGio'   => $kg,
    ]);
}

    // ===== 2. Lấy giờ đã đặt =====
    public function layGioDaDat(Request $request)
    {
        $sp = new Product();

        $ngay = $request->ngay;
        $idXeMau = (int)$request->id_xe_mau;

        $gioDaDat = [];
        $result = $sp->getGioDaDat($ngay, $idXeMau); // bạn phải có function này

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $gioDaDat[] = $row['id_Khung_Gio'];
            }
        }

        return response()->json($gioDaDat);
    }

    // ===== 3. Xử lý đặt lịch =====
    public function store(Request $request)
{
    $sp = new Product();

    $idKhach     = session('user_id');
    if (!$idKhach) {
        return redirect('car_shop/dangnhap')->with('error', 'Vui lòng đăng nhập để đặt lịch lái thử.');
    }
    $idXeMau     = (int)$request->id_xe_mau;
    $ngay        = $request->ngay_lai_thu;
    $idKhungGio  = (int)$request->id_Khung_Gio;

    
    $checkKhach = $sp->kiemTraKhachDaDat($idKhach, $idXeMau, $ngay);

    if ($checkKhach && $checkKhach->num_rows > 0) {
        return back()->with('error', 'Bạn đã đặt lịch lái thử xe này trong ngày này rồi.');
    }

    
    $checkSlot = $sp->kiemTraSlotDaDat($idXeMau, $ngay, $idKhungGio);

    if ($checkSlot && $checkSlot->num_rows > 0) {
        return back()->with('error', 'Khung giờ này đã có người đặt.');
    }

    
    $sp->insertLichLaiThu($idKhach, $idXeMau, $ngay, $idKhungGio);

    return redirect('/user/car_shop/lich-lai-thu-cua-toi')
       ->with('success', 'Đặt lịch thành công!');
}
 public function lichCuaToi()
{
    $User = new User();

    $idKhach = session('user_id');   // ✅ dùng session() của Laravel

    if (!$idKhach) {
        return redirect('car_shop/dangnhap')
            ->with('error', 'Vui lòng đăng nhập.');
    }

    $danhSach = $User->LichLaiThu_CuaToi($idKhach);

    return view('user.layouts.lichlaithu', [
        'danh_sach' => $danhSach
    ]);
}
}