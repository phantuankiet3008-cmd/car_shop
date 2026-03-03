<?php

namespace App\Http\Controllers\User; // Đảm bảo đúng namespace
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\Product; // << Gọi công nhân Product của nhóm vào


class danhsachsanphamController extends Controller
{
    // Cực kỳ quan trọng: Nhận $IDloai và $IDTH thẳng từ Router
    public function index(Request $request, $IDloai, $IDTH)
    {

        // 1. Ép kiểu 2 cái ID từ đường link thành số nguyên cho an toàn
        $maLoai = (int)$IDloai;
        $maThuongHieu = (int)$IDTH;

        // 2. Lấy tham số 'search' từ query string (ví dụ: ?search=từ-khóa)
        // Dùng return null (chuỗi trống) nếu không có search
        $search = trim($request->query('search', ''));

        // 3. Khởi tạo class Product
        $sp = new Product();

        // 4. TRUYỀN PARAM VÀO HÀM LỌC SẢN PHẨM Ở MODEL
        // Cú pháp chuẩn của hàm là: locSanPham($search, $MaLoai, $MaThuongHieu)
        $danhSachXe = $sp->locSanPham($search, $maLoai, $maThuongHieu);
        
        // 5. Lấy danh sách loại xe và thương hiệu cho phần Sidebar lọc
        $loaiXeList = $sp->getAllLoaiXe();
        $thuongHieuList = $sp->getAllThuongHieu();

        // 6. Gửi dữ liệu ra View
       return view('user.layouts.danhsachsanpham', compact(
            'danhSachXe', 
            'loaiXeList', 
            'thuongHieuList', 
            'search', 
            'maLoai', 
            'IDTH' // <-- Change back to IDTH
        ));

       
    }
}
