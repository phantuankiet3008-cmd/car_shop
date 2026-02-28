<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Product; // << Gọi công nhân Product của nhóm vào

class danhsachsanphamController extends Controller
{
    public function index(Request $request)
    {
        // 1. Nhận dữ liệu bộ lọc
        $search = trim($request->input('search', ''));
        $maLoai = (int) $request->input('MaLoai', 0);
        $maThuongHieu = (int) $request->input('MaThuongHieu', 0);

        // 2. Chuẩn form nhóm: Khởi tạo Class
        $sp = new Product();

        // 3. Gọi hàm từ Class Product
        $danhSachXe = $sp->locSanPham($search, $maLoai, $maThuongHieu);
        $loaiXeList = $sp->getAllLoaiXe();
        $thuongHieuList = $sp->getAllThuongHieu();

        // 4. Quăng ra View
        return view('user.layouts.danhsachsanpham', compact('danhSachXe', 'loaiXeList', 'thuongHieuList', 'search', 'maLoai', 'maThuongHieu'));
    }
}